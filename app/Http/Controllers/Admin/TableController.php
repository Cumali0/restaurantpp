<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;
use App\Models\Reservation;

use Carbon\Carbon;

class TableController extends Controller
{



    public function index(Request $request)
    {
        $tables = Table::all();
        // Kapasite ve kat için benzersiz değerleri alalım (filtre dropdownları için)
        $capacities = Table::select('capacity')->distinct()->orderBy('capacity')->pluck('capacity');
        $floors = Table::select('floor')->distinct()->orderBy('floor')->pluck('floor');

        // Query builder ile tablodaki masaları sorgula
        $query = Table::query();

        if ($request->filled('capacity')) {
            $query->where('capacity', $request->capacity);
        }

        if ($request->filled('floor')) {
            $query->where('floor', $request->floor);
        }

        $tables = $query->get();

        return view('admin.tables.index', compact('tables', 'capacities', 'floors'));
    }

    // AJAX ile rezervasyonları döndüren method
    public function getReservations(Request $request, $tableId)
    {
        $query = Reservation::where('table_id', $tableId);

        if ($request->date) {
            $query->whereDate('datetime', $request->date);
        }

        if ($request->start_time) {
            $query->whereTime('datetime', '>=', $request->start_time);
        }

        if ($request->end_time) {
            $query->whereTime('end_datetime', '<=', $request->end_time);
        }

        $reservations = $query->orderBy('datetime')->get();

        // Burada direkt HTML döndürüyoruz
        if ($reservations->count() > 0) {
            $html = '<ul style="list-style:none; padding:0;">';
            foreach ($reservations as $reservation) {
                $html .= '<li style="border-bottom: 1px solid #ddd; padding: 8px 0;">
                    <strong>' . e($reservation->name) . ' ' . e($reservation->surname) . '</strong><br>
                    ' . $reservation->datetime->format('H:i') . ' - ' . $reservation->end_datetime->format('H:i') . '<br>
                    Kişi: ' . e($reservation->people) . ' | Durum: ' . ucfirst($reservation->status) . '
                </li>';
            }
            $html .= '</ul>';
        } else {
            $html = '<p style="color:green;">Bu masada rezervasyon yok.</p>';
        }

        return response($html);
    }




    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'capacity' => 'required|integer',
            // 'status' => 'required|in:available,booked',
            'floor' => 'nullable|integer',
        ]);

        Table::create($request->all());

        return redirect()->route('tables.index')->with('success', 'Masa başarıyla eklendi.');
    }

    public function update(Request $request, Table $table)
    {
        $request->validate([
            'name' => 'required',
            'capacity' => 'required|integer',

            'floor' => 'nullable|integer',
        ]);

        $table->update($request->all());

        return redirect()->route('tables.index')->with('success', 'Masa başarıyla güncellendi.');
    }

    public function destroy(Table $table)
    {
        $table->delete();

        return redirect()->route('tables.index')->with('success', 'Masa başarıyla silindi.');
    }
}
