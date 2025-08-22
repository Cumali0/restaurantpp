<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservationController extends Controller
{
// Tüm rezervasyonları listele
public function index()
{
$reservations = Reservation::with('table', 'user')->orderBy('datetime', 'desc')->get();
return view('admin.reservations.index', compact('reservations'));
}

// Tek rezervasyonu detaylı göster
public function show($id)
{
$reservation = Reservation::with('table', 'user')->findOrFail($id);
return view('admin.reservations.show', compact('reservation'));
}

// Rezervasyonu onayla
public function approve($id)
{
$reservation = Reservation::findOrFail($id);
$reservation->status = 'approved';
$reservation->save();

return redirect()->back()->with('success', 'Rezervasyon onaylandı.');
}

// Rezervasyonu reddet
public function reject($id)
{
$reservation = Reservation::findOrFail($id);
$reservation->status = 'rejected';
$reservation->save();

return redirect()->back()->with('success', 'Rezervasyon reddedildi.');
}

// Rezervasyonu sil
public function destroy($id)
{
$reservation = Reservation::findOrFail($id);
$reservation->delete();

return redirect()->back()->with('success', 'Rezervasyon silindi.');
}
}
