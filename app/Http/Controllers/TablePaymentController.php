<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\ReservationLog;

class TablePaymentController extends Controller
{
    // Ödeme formunu göster
    public function showPaymentForm(Reservation $reservation)
    {
        return view('table.payment-form', compact('reservation'));
    }

    // Ödeme işlemini yap
    public function payTableFee(Request $request, Reservation $reservation)
    {
        $request->validate([
            'card_holder_name' => 'required|string|max:255',
            'card_number' => 'required|string',
            'expire_month' => 'required|string',
            'expire_year' => 'required|string',
            'cvc' => 'required|string',
        ]);

        // 10 dk ödeme süresi kontrolü
        if ($reservation->payment_status == 'unpaid' && $reservation->created_at->diffInMinutes(now()) > 10) {
            ReservationLog::create([
                'reservation_id' => $reservation->id,
                'action' => 'expired',
                'note' => 'Ödeme süresi doldu, rezervasyon silindi.'
            ]);
            $reservation->delete();

            return redirect()->back()->with('error', 'Ödeme süreniz dolduğu için rezervasyon iptal edildi.');
        }

        $amount = $reservation->table->preprice;

        // Ödeme kaydı oluştur
        $payment = Payment::create([
            'reservation_id' => $reservation->id,
            'table_id' => $reservation->table_id,
            'payment_method_id' => 1, // Default: IyziCo
            'amount_price' => $amount,
            'status' => 'paid',
        ]);

        $reservation->payment_status = 'paid';
        $reservation->save();

        return redirect()->route('table.pay.form', $reservation->id)
            ->with('success', "Masa ücreti ödendi: {$amount} TL");
    }
}
