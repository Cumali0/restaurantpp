<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Reservation;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function showForm(Request $request)
    {
        $type = $request->query('chartType', 'monthly'); // monthly veya yearly
        $now = now();

        $labels = [];
        $ordersData = [];
        $reservationsData = [];
        $revenueData = [];

        if ($type == 'monthly') {
            for ($i = 11; $i >= 0; $i--) {
                $month = $now->copy()->subMonths($i);
                $labels[] = $month->format('M Y');

                // Sipariş sayısı rezervasyon tarihine göre
                $ordersData[] = Order::whereHas('reservation', function($q) use ($month) {
                    $q->whereYear('datetime', $month->year)
                        ->whereMonth('datetime', $month->month);
                })->count();

                // Rezervasyon sayısı
                $reservationsData[] = Reservation::whereYear('datetime', $month->year)
                    ->whereMonth('datetime', $month->month)->count();

                // Gelirler rezervasyon tarihine göre
                $revenueData[] = Order::whereHas('reservation', function($q) use ($month) {
                    $q->whereYear('datetime', $month->year)
                        ->whereMonth('datetime', $month->month);
                })->sum('total_price');
            }
        } elseif ($type == 'yearly') {
            for ($i = 4; $i >= 0; $i--) {
                $year = $now->copy()->subYears($i)->year;
                $labels[] = $year;

                $ordersData[] = Order::whereHas('reservation', function($q) use ($year) {
                    $q->whereYear('datetime', $year);
                })->count();

                $reservationsData[] = Reservation::whereYear('datetime', $year)->count();

                $revenueData[] = Order::whereHas('reservation', function($q) use ($year) {
                    $q->whereYear('datetime', $year);
                })->sum('total_price');
            }
        }

        return view('admin.reports.form', compact(
            'labels','ordersData','reservationsData','revenueData','type'
        ));
    }

    public function generate(Request $request)
    {
        $type = $request->query('type', 'daily');
        $now = now();

        switch ($type) {
            case 'daily':
                $start = $now->copy()->startOfDay();
            case 'weekly':
                $start = $now->copy()->startOfWeek();
                $end = $now->copy()->endOfWeek();
                break;

            case 'monthly':
                $start = $now->copy()->startOfMonth();
                $end = $now->copy()->endOfMonth();
                break;

            case 'yearly':
                $start = $now->copy()->startOfYear();
                $end = $now->copy()->endOfYear();
                break;

            default:
                $start = $now->copy()->startOfDay();
                $end = $now->copy()->endOfDay();
        }

        // Siparişler artık rezervasyon tarihine göre
        $orders = Order::whereHas('reservation', function($q) use ($start, $end) {
            $q->whereBetween('datetime', [$start, $end]);
        })->with('items.product,reservation')->get();

        $reservations = Reservation::whereBetween('datetime', [$start, $end])->get();

        $totalRevenue = $orders->sum('total_price');

        $topProducts = \App\Models\OrderItem::selectRaw('product_id, SUM(quantity) as total_quantity')
            ->whereHas('order.reservation', function($q) use ($start, $end) {
                $q->whereBetween('datetime', [$start, $end]);
            })
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->take(10)
            ->get();

        $pdf = PDF::loadView('admin.reports.master', compact(
            'orders', 'reservations', 'totalRevenue', 'topProducts', 'start', 'end', 'type'
        ));

        return $pdf->download("report_{$type}_{$now->format('Y-m-d')}.pdf");
    }
}
