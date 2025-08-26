@extends('admin.layouts.app')

@section('title', 'Raporlar')

@section('content')
    <div class="container-fluid py-4 px-3">
        <h2 class="mb-4">Raporlar</h2>

        <!-- Rapor ve PDF Seçimi -->
        <form method="GET" action="{{ route('admin.reports.generate') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-3 col-sm-6">
                    <label class="form-label">Rapor Türü</label>
                    <select name="type" class="form-select">
                        <option value="daily">Günlük</option>
                        <option value="weekly">Haftalık</option>
                        <option value="monthly">Aylık</option>
                        <option value="yearly">Yıllık</option>
                    </select>
                </div>
                <div class="col-md-2 col-sm-6 d-grid">
                    <button type="submit" class="btn btn-danger">PDF İndir</button>
                </div>
            </div>
        </form>

        <!-- Grafik Türü Seçimi -->
        <div class="my-4">
            <label class="form-label">Grafik Gösterimi</label>
            <select id="chartType" class="form-select w-100 w-md-25">
                <option value="monthly" {{ $type=='monthly'?'selected':'' }}>Aylık (Son 12 Ay)</option>
                <option value="yearly" {{ $type=='yearly'?'selected':'' }}>Yıllık (Son 5 Yıl)</option>
            </select>
        </div>

        <!-- Özet Kartları (Yan Yana, Belirgin, Hover Efektli) -->
        <div class="col-lg-4 col-md-6">

        @php $cardHeight = '220px'; @endphp
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-lg border-0 text-center h-100 rounded-4 bg-white hover-shadow" style="height: {{ $cardHeight }}">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <h6 class="card-title text-primary mb-2">Toplam Sipariş</h6>
                        <p class="display-6 fw-bold">{{ array_sum($ordersData) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-lg border-0 text-center h-100 rounded-4 bg-white hover-shadow" style="height: {{ $cardHeight }}">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <h6 class="card-title text-success mb-2">Toplam Rezervasyon</h6>
                        <p class="display-6 fw-bold">{{ array_sum($reservationsData) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-lg border-0 text-center h-100 rounded-4 bg-white hover-shadow" style="height: {{ $cardHeight }}">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <h6 class="card-title text-warning mb-2">Toplam Gelir</h6>
                        <p class="display-6 fw-bold">{{ number_format(array_sum($revenueData),2) }}₺</p>
                    </div>
                </div>
            </div>
        </div>

        <style>
            /* Kart Hover Efekti */
            .hover-shadow {
                transition: all 0.3s ease;
            }
            .hover-shadow:hover {
                transform: translateY(-8px);
                box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.3) !important;
            }

            /* Kart Başlık ve Sayılar */
            .card-title { font-size: 1rem; font-weight: 600; }
            .display-6 { font-size: 2.5rem; }
        </style>


        <!-- Grafikler -->
        <div class="row g-4">
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm border-0 p-3">
                    <h6 class="text-center mb-3">Sipariş Grafiği</h6>
                    <canvas id="ordersChart"></canvas>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm border-0 p-3">
                    <h6 class="text-center mb-3">Rezervasyon Grafiği</h6>
                    <canvas id="reservationsChart"></canvas>
                </div>
            </div>
            <div class="col-12">
                <div class="card shadow-sm border-0 p-3">
                    <h6 class="text-center mb-3">Gelir Grafiği</h6>
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Grafik yüksekliği tüm cihazlarda uyumlu */
        canvas {
            width: 100% !important;
            height: 300px !important;
        }

        @media (min-width: 992px) {
            canvas { height: 350px !important; }
        }

        /* Kart başlıkları ve sayılar daha okunaklı */
        .card-title { font-size: 1rem; font-weight: 600; }
        .display-6 { font-size: 2.5rem; }
    </style>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const chartTypeSelect = document.getElementById('chartType');
        chartTypeSelect.addEventListener('change', function() {
            const selected = this.value;
            window.location.href = "{{ route('admin.reports.form') }}?chartType=" + selected;
        });

        const labels = @json($labels);
        const ordersData = @json($ordersData);
        const reservationsData = @json($reservationsData);
        const revenueData = @json($revenueData);

        // Daha modern renkler
        const ordersColor = 'rgba(255, 99, 132, 0.6)';
        const ordersBorder = 'rgba(255, 99, 132, 1)';
        const reservationsColor = 'rgba(54, 162, 235, 0.6)';
        const reservationsBorder = 'rgba(54, 162, 235, 1)';

        const revenueCanvas = document.getElementById('revenueChart').getContext('2d');
        const gradient = revenueCanvas.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(255, 206, 86, 0.6)');
        gradient.addColorStop(1, 'rgba(255, 206, 86, 0)');

        // Sipariş Grafiği
        new Chart(document.getElementById('ordersChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Sipariş Sayısı',
                    data: ordersData,
                    backgroundColor: ordersColor,
                    borderColor: ordersBorder,
                    borderWidth: 1.5,
                    hoverBackgroundColor: 'rgba(255, 99, 132, 0.9)'
                }]
            },
            options: {
                responsive: true,
                animation: { duration: 1200, easing: 'easeOutQuart' },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: context => context.dataset.label + ': ' + context.parsed.y.toLocaleString('tr-TR') + ' adet'
                        }
                    },
                    legend: {
                        display: true,
                        position: 'top',
                        labels: { font: { size: 14 } }
                    },
                    title: {
                        display: true,
                        text: 'Aylık/Yıllık Sipariş Grafiği',
                        font: { size: 18 }
                    }
                },
                scales: { y: { beginAtZero: true } }
            }
        });

        // Rezervasyon Grafiği
        new Chart(document.getElementById('reservationsChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Rezervasyon Sayısı',
                    data: reservationsData,
                    backgroundColor: reservationsColor,
                    borderColor: reservationsBorder,
                    borderWidth: 1.5,
                    hoverBackgroundColor: 'rgba(54, 162, 235, 0.9)'
                }]
            },
            options: {
                responsive: true,
                animation: { duration: 1200, easing: 'easeOutQuart' },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: context => context.dataset.label + ': ' + context.parsed.y.toLocaleString('tr-TR') + ' adet'
                        }
                    },
                    legend: {
                        display: true,
                        position: 'top',
                        labels: { font: { size: 14 } }
                    },
                    title: {
                        display: true,
                        text: 'Aylık/Yıllık Rezervasyon Grafiği',
                        font: { size: 18 }
                    }
                },
                scales: { y: { beginAtZero: true } }
            }
        });

        // Gelir Grafiği
        new Chart(revenueCanvas, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Gelir (₺)',
                    data: revenueData,
                    backgroundColor: gradient,
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgba(255, 206, 86, 1)',
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                animation: { duration: 1400, easing: 'easeOutQuart' },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: context => context.dataset.label + ': ' + context.parsed.y.toLocaleString('tr-TR') + '₺'
                        }
                    },
                    legend: {
                        display: true,
                        position: 'top',
                        labels: { font: { size: 14 } }
                    },
                    title: {
                        display: true,
                        text: 'Aylık/Yıllık Gelir Grafiği',
                        font: { size: 18 }
                    }
                },
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>


@endsection
