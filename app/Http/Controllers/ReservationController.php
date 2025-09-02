<?php

namespace App\Http\Controllers;

use App\Mail\ReservationCreatedMail;
use App\Mail\ReservationStatusMail;

use App\Models\Table;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    public function storePublic(Request $request)
    {

            $request->validate([
                'table_id' => 'required|exists:tables,id',
                'name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'email' => 'required|email|max:255',
                'datetime' => 'required|date_format:Y-m-d H:i',
                'people' => 'required|integer|min:1',
                'message' => 'nullable|string',
                'duration' => 'nullable|integer|min:15|max:240',
                'is_preorder' => 'nullable|boolean'


        ]);

        $start = $request->datetime;
        $end = \Carbon\Carbon::parse($start)->addMinutes($request->duration ?? 90);
        $table = Table::find($request->table_id);
        $totalPrice = $table->preprice;


        $reservation = Reservation::create([
            'table_id' => $request->table_id,
            'name' => $request->name,
            'surname' => $request->surname,
            'phone' => $request->phone,
            'email' => $request->email,
            'datetime' => $start,
            'end_datetime' => $end,
            'people' => $request->people,
            'message' => $request->message,
            'status' => 'reserved',
            'is_preorder' => $request->has('is_preorder'),
            'total_price' => $table->preprice,
            'payment_status' => 'unpaid',
            'preorder_token' => Str::random(32), // random token
            'user_id' => auth()->id(),
        ]);

        Mail::to($reservation->email)->send(new ReservationCreatedMail($reservation));


        return response()->json([
            'success' => true,
            'message' => 'Rezervasyon başarıyla oluşturuldu.',
            'preorder_url' => route('reservation.preorder', $reservation->preorder_token)
        ]);

    }



    public function reject($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->status = 'rejected';
        $reservation->save();

        // Müşteriye mail gönder
        Mail::to($reservation->email)->send(new ReservationStatusMail($reservation));

        return redirect()->route('reservations.index')->with('success', 'Rezervasyon reddedildi ve müşteriye mail gönderildi.');
    }










    public function index(Request $request)
    {
        $query = Reservation::query();

        if ($request->filled('table_id')) {
            $query->where('table_id', $request->input('table_id'));
        }

        if ($request->filled('name')) {
            $name = $request->input('name');
            $query->where(function ($q) use ($name) {
                $q->where('name', 'like', "%{$name}%")
                    ->orWhere('surname', 'like', "%{$name}%");
            });
        }

        $start = $request->input('datetime_start');
        $end = $request->input('datetime_end');

        if ($start && $end) {
            $startDate = Carbon::parse($start)->format('Y-m-d H:i:s');
            $endDate = Carbon::parse($end)->format('Y-m-d H:i:s');

            $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('datetime', [$startDate, $endDate])
                    ->orWhereBetween('end_datetime', [$startDate, $endDate])
                    ->orWhere(function ($q2) use ($startDate, $endDate) {
                        $q2->where('datetime', '<=', $startDate)
                            ->where('end_datetime', '>=', $endDate);
                    });
            });
        } elseif ($start) {
            $startDate = Carbon::parse($start)->format('Y-m-d H:i:s');
            $query->where('datetime', '>=', $startDate);
        } elseif ($end) {
            $endDate = Carbon::parse($end)->format('Y-m-d H:i:s');
            $query->where('end_datetime', '<=', $endDate);
        }

        $reservations = $query->orderBy('datetime', 'asc')->paginate(10)->withQueryString();

        return view('admin.reservations.index', compact('reservations'));
    }



    // Yeni rezervasyon ekleme
    public function store(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'datetime' => 'required|date_format:Y-m-d H:i',
            'people' => 'required|integer|min:1',
            'message' => 'nullable|string',
            'duration' => 'nullable|integer|min:15|max:240',
            'is_preorder' => 'nullable|boolean'
        ]);

        $start = Carbon::createFromFormat('Y-m-d H:i', $request->datetime);
        $duration = (int)$request->input('duration', 90);
        $end = $start->copy()->addMinutes($duration);

        // Çalışma saatleri kontrolü (aynı şekilde)
        $day = $start->dayOfWeek;
        $time = $start->format('H:i');

        if ($day === 0) {
            if ($time < '10:00' || $time > '20:00') {
                return back()->withErrors(['datetime' => 'Pazar günleri rezervasyonlar 10:00 - 20:00 saatleri arasında yapılabilir.'])->withInput();
            }
        } else {
            if ($time < '09:00' || $time > '21:00') {
                return back()->withErrors(['datetime' => 'Rezervasyonlar 09:00 - 21:00 saatleri arasında yapılabilir.'])->withInput();
            }
        }

        // Çakışma kontrolü
        $conflict = Reservation::where('table_id', $request->table_id)
            ->whereIn('status', ['reserved', 'approved'])
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($q) use ($start, $end) {
                    $q->where('datetime', '<', $end)
                        ->where('end_datetime', '>', $start);
                });
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors(['table_id' => 'Seçilen masa bu zaman aralığında doludur!'])->withInput();
        }

        try {
            $reservation = Reservation::create([
                'table_id' => $request->table_id,
                'name' => $request->name,
                'surname' => $request->surname,
                'phone' => $request->phone,
                'email' => $request->email,
                'datetime' => $start,
                'end_datetime' => $end,
                'people' => $request->people,
                'message' => $request->message,
                'status' => 'reserved',
                'is_preorder' => $request->has('is_preorder'),
                'preorder_token' => Str::random(32),
            ]);

            // Ödeme URL'si her zaman oluşturulsun
            $paymentUrl = route('table.payment.form', ['reservation' => $reservation->id]);

            $response = [
                'success' => true,
                'message' => 'Rezervasyon başarıyla oluşturuldu.',
                'payment_url' => $paymentUrl,
            ];

            // Ön sipariş varsa ayrıca ön sipariş URL'si ekle
            if ($reservation->is_preorder) {
                $response['preorder_url'] = route('reservation.preorder', $reservation->preorder_token);
            }

            if ($request->ajax()) {
                return response()->json($response);
            }

            return back()->with('success', 'Rezervasyon başarıyla gönderildi.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Rezervasyon gönderilirken hata oluştu.']);
            }
            return back()->with('error', 'Rezervasyon gönderilirken hata oluştu.');
        }
    }



        // Rezervasyonu onaylama
    public function approve($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->status = 'approved';
        $reservation->save();

        Mail::to($reservation->email)->send(new ReservationStatusMail($reservation));


        return redirect()->route('reservations.index')->with('success', 'Rezervasyon onaylandı ve müsteriye mail gönderildi.');
    }

    // Rezervasyonu silme
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        Mail::to($reservation->email)->send(new ReservationStatusMail($reservation));

        return redirect()->route('reservations.index')->with('success', 'Rezervasyon silindi ve  müsteriye mail gönderildi.');
    }

    // AJAX: Tarih ve süreye göre masa uygunluk durumu (boş/dolu)
    public function tablesAvailability(Request $request)
    {
        $datetime = $request->query('datetime');
        $duration = (int) $request->query('duration', 90); // kesin int cast

        if (!$datetime) {
            return response()->json(['error' => 'Datetime parameter required'], 400);
        }

        $start = Carbon::parse($datetime);
        $end = $start->copy()->addMinutes($duration);

        // Tüm masalar
        $tables = Table::orderBy('name')->get();

        // Çakışan rezervasyonlar (zaman aralığı örtüşenler)
        $conflictingReservations = Reservation::whereIn('status', ['reserved', 'approved'])
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($q) use ($start, $end) {
                    $q->where('datetime', '<', $end)
                        ->where('end_datetime', '>', $start);
                });
            })
            ->pluck('table_id')
            ->toArray();

        $available = [];
        $booked = [];

        foreach ($tables as $table) {
            if (in_array($table->id, $conflictingReservations)) {
                $booked[] = ['id' => $table->id, 'name' => $table->name];
            } else {
                $available[] = ['id' => $table->id, 'name' => $table->name];
            }
        }

        return response()->json([
            'available' => $available,
            'booked' => $booked,
        ]);
    }

// Kullanıcının kendi rezervasyonları
    public function myReservations()
    {
        $reservations = Reservation::where('user_id', auth()->id())->orderBy('datetime', 'asc')->get();
        return view('user.reservations.index', compact('reservations'));
    }


    // Rezervasyonu güncelle (mesaj ve kişi sayısı)
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'people' => 'required|integer|min:1|max:'.$reservation->table->capacity,
            'message' => 'nullable|string|max:255',
        ]);

        $reservation->people = $request->people;
        $reservation->message = $request->message;
        $reservation->save();

        return response()->json(['success' => true, 'message' => 'Rezervasyon güncellendi']);
    }

// Rezervasyonu iptal et
    public function cancel($id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }

        $reservation->delete();

        return response()->json(['success' => true, 'message' => 'Rezervasyon iptal edildi']);
    }


}
