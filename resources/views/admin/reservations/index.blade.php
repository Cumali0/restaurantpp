@extends('admin.layouts.app')

@section('content')

    <div  class="col-12 col-md-8">
        <h1>Reservations List</h1>



        {{-- Filtre formu --}}
        <form method="GET" action="{{ route('reservations.index') }}" class="row g-2 align-items-center filter-form">

            <div  class="col-auto">
                <input type="text" name="table_id" placeholder="Masa Numarası" value="{{ request('table_id') }}" />
            </div>
            <div class="col-auto">
                <input type="text" name="name" placeholder="İsim veya Soyisim" value="{{ request('name') }}" />
            </div>
            <div class="col-auto">
                <input type="text" id="datetime" name="datetime_start" placeholder="Başlangıç Tarih & Saat" value="{{ request('datetime') }}" autocomplete="off" />
            </div>

            <div class="col-auto">
                <input type="text" id="end_datetime" name="datetime_end" placeholder="Bitiş Tarih & Saat" value="{{ request('end_datetime') }}" autocomplete="on" />

            </div>
            <div class="col-auto d-flex gap-2">
                <button type="submit">Filtrele</button>
                <a href="{{ route('reservations.index') }}" style="text-decoration:none; padding: 6px 10px; border: 1px solid #ccc; color:#333;">Temizle</a>
            </div>
        </form>

        @if(session('success'))
            <div style="color:green;">{{ session('success') }}</div>
        @endif

        <table border="1" cellpadding="10" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Masa Numarası</th> <!-- Yeni sütun -->
                <th>İsim</th>
                <th>Soyad</th>
                <th>Telefon</th>
                <th>Email</th>  <!-- Buraya eklendi -->
                <th>Tarih ve Zaman</th>
                <th>Durum</th>
                <th>Seçimler</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->table_id}}</td> <!-- Masa numarası -->
                    <td>{{ $reservation->name }}</td>
                    <td>{{ $reservation->surname }}</td>
                    <td>{{ $reservation->phone }}</td>
                    <td>{{ $reservation->email }}</td>  <!-- Buraya eklendi -->
                    <td>{{ $reservation->datetime }}</td>
                    <td>{{ ucfirst($reservation->status) }}</td>
                    <td style="display: flex">
                        @if ($reservation->status != 'approved')
                            <form action="{{ route('reservations.approve', $reservation->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button  type="submit">Onaylamak</button>
                            </form>
                        @endif

                        @if ($reservation->status != 'rejected')
                            <form action="{{ route('reservations.reject', $reservation->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button  type="submit" onclick="return confirm('Bu rezervasyonu reddetmek istediğinize emin misiniz?')">Reddetmek</button>
                            </form>
                        @endif

                        <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" style="display:inline-block; ">
                            @csrf
                            @method('DELETE')
                            <button   type="submit" onclick="return confirm('Rezervasyonu silmek istediğinize emin misiniz?')">Silmek</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">No reservations found.</td></tr>


            @endforelse


            </tbody>




        </table>
    </div>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            table-layout: auto; /* Önemli */
        }

        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        thead {
            background-color: #007BFF;
            color: white;
            font-weight: bold;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }

        button {
            background-color: #007BFF;
            border: none;
            color: white;
            padding: 6px 12px;
            margin: 1px 2px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        button.reject {
            background-color: #dc3545;
        }

        button.reject:hover {
            background-color: #a71d2a;
        }

        button.delete {
            background-color: #6c757d;
        }

        button.delete:hover {
            background-color: #4e555b;
        }


        table {
            border-collapse: collapse; /* Önemli: Kenarların birleşmesi için */
            width: 100%;
        }

        th, td {
            border-bottom: 1px solid #ddd; /* Açık gri alt çizgi */
            padding: 60px 15px; /* Yeterli iç boşluk */
            text-align: center;

        }

        tbody tr:last-child td {
            border-bottom: none; /* Son satır alt çizgisi isteğe bağlı */
        }

        thead th {
            background-color: #007BFF; /* Senin mavi başlık */
            color: white;
            border-bottom: 2px solid #0056b3; /* Başlık altında koyu çizgi */

        }

        table thead th {
            padding: 0 65px;
            border: 1px solid #ddd;

        }



        .pagination {
            display: flex;
            justify-content: center;
            padding-left: 0;
            list-style: none;
            border-radius: 0.5rem;
            gap: 0.8rem;
            flex-wrap: wrap;
            user-select: none;
            width: 1203px;
        }

        /* Sayfa numarası butonları */
        .pagination li a,
        .pagination li span {
            color: #495057;
            background-color: #f8f9fa;
            border: 1.7px solid #dee2e6;
            padding: 9px 10px;
            text-decoration: none;
            font-weight: 700;
            border-radius: 50%;
            min-width: 30px;
            height: 30px;
            line-height: 26px;
            text-align: center;
            transition: background-color 0.35s ease, color 0.35s ease, box-shadow 0.35s ease, border-color 0.35s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-sizing: border-box;
        }

        /* Hover ve focus efektleri */
        .pagination li a:hover,
        .pagination li a:focus {
            background: linear-gradient(270deg, #0d6efd, #4dabf7, #0d6efd);
            background-size: 600% 600%;
            animation: slideGlow 3s ease infinite;
            color: #fff;
            border-color: #0d6efd;
            box-shadow: 0 0 12px rgba(13, 110, 253, 0.8);
            outline: none;
        }

        /* Aktif sayfa */
        .pagination li.active span {
            background-color: #0d6efd;
            color: white;
            border-color: #0a58ca;
            box-shadow: 0 0 16px #0d6efd;
            font-weight: 900;
            cursor: default;
            transform: scale(1.1);
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }

        /* Devre dışı butonlar */
        .pagination li.disabled span {
            color: #adb5bd;
            cursor: not-allowed;
            background-color: #e9ecef;
            border-color: #dee2e6;
            box-shadow: none;
        }

        /* Önceki ve Sonraki butonları için modern SVG ikonları (inline) */
        .pagination li:first-child a::before,
        .pagination li:last-child a::after {
            display: inline-flex;
            vertical-align: middle;
            width: 16px;
            height: 16px;
            content: '';
            background-size: contain;
            background-repeat: no-repeat;
            margin: 0 6px;
            transition: filter 0.3s ease;
        }

        /* Önceki: sola ok */
        .pagination li:first-child a::before {
            background-image: url('data:image/svg+xml;utf8,<svg fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>');
        }

        /* Sonraki: sağa ok */
        .pagination li:last-child a::after {
            background-image: url('data:image/svg+xml;utf8,<svg fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/></svg>');
        }

        /* Hover efektlerinde ikon parlaklığı */
        .pagination li:first-child a:hover::before,
        .pagination li:last-child a:hover::after {
            filter: drop-shadow(0 0 3px #fff);
        }

        /* Önceki ve sonraki butonlara özel stil */
        .pagination li:first-child a,
        .pagination li:last-child a {
            min-width: auto;
            padding: 8px 14px;
            border-radius: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        /* Sayfa numarası butonlarıyla farklı görünsün */
        .pagination li a:not(:first-child):not(:last-child),
        .pagination li span:not(:first-child):not(:last-child) {
            min-width: 40px;
            height: 40px;
            padding: 9px 10px;
            border-radius: 50%;
        }

        /* Responsive: küçük ekranlarda biraz küçült */
        @media (max-width: 576px) {
            .pagination li a,
            .pagination li span {
                min-width: 36px;
                height: 36px;
                padding: 6px 10px;
                font-size: 0.85rem;
            }
        }

        /* Glow animasyon */
        @keyframes slideGlow {
            0% {
                background-position: 0% 50%;
                box-shadow: 0 0 10px #0d6efd;
            }
            50% {
                background-position: 100% 50%;
                box-shadow: 0 0 20px #0d6efd;
            }
            100% {
                background-position: 0% 50%;
                box-shadow: 0 0 10px #0d6efd;
            }
        }

        .pagination-wrapper {
            display: inline-block;
            text-align: center;
            width: 100%;
            max-width: 300px;
        }

        .pagination-wrapper button {
            background-color: #0d6efd;
            color: white;
            font-weight: 700;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 6px;
            padding: 8px 12px;
            width: 100%;
        }

        .pagination-wrapper button:hover {
            background-color: #0a58ca;
        }

        .pagination {
            display: flex !important;
            flex-wrap: nowrap !important; /* Alt satıra kaymasın */
            gap: 0.2rem; /* Düğmeler arası boşluk */
        }


        .filter-form {
            display: flex;

            gap: 10px;
            align-items: center;
        }

        .filter-form input {
            flex: 1 1 200px; /* Esnek boyutlandırma */
            min-width: 160px;
            padding: 6px 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }


        .filter-form button,
        .filter-form a {
            white-space: nowrap;
            padding: 6px 16px;
            border: 1px solid #ccc;
            background-color: #f5f5f5;
            color: #333;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            display: flex;    /* Buton içi metin satır atlamasın */
            transition: background-color 0.3s ease;
        }


        /* Küçük ekranlar için tam genişlik */
        @media (max-width: 768px) {
            .filter-form input,
            .filter-form button,
            .filter-form .btn-clear {
                flex: 1 1 100%;
            }
        }

        /* 1. Büyük masaüstü: > 1600px */
        @media (min-width: 1600px) {
            table th, table td {
                padding: 20px 25px;
                font-size: 16px;
            }
            .filter-form input, .filter-form button, .filter-form a {
                padding: 10px 18px;
                font-size: 15px;
            }
        }

        /* 2. Standart masaüstü: 1200px - 1599px */
        @media (min-width: 1200px) and (max-width: 1599px) {
            table th, table td {
                padding: 18px 20px;
                font-size: 15px;
            }
        }

        /* 3. Laptop: 992px - 1199px */
        @media (min-width: 992px) and (max-width: 1199px) {
            table th, table td {
                padding: 15px 18px;
                font-size: 14px;
            }
            .filter-form {
                flex-wrap: wrap;
            }
            .filter-form input, .filter-form button, .filter-form a {
                flex: 1 1 45%;
                margin-bottom: 8px;
            }
        }

        /* 4. Tablet: 768px - 991px */
        @media (min-width: 768px) and (max-width: 991px) {
            table th, table td {
                padding: 12px 15px;
                font-size: 13px;
            }
            .filter-form input, .filter-form button, .filter-form a {
                flex: 1 1 48%;
                margin-bottom: 6px;
            }
        }

        /* 5. Büyük telefon / küçük tablet: 576px - 767px */
        @media (min-width: 576px) and (max-width: 767px) {
            table th, table td {
                padding: 10px 12px;
                font-size: 12px;
            }
            .filter-form input, .filter-form button, .filter-form a {
                flex: 1 1 100%;
                margin-bottom: 6px;
            }
        }

        /* 6. Küçük telefon: < 575px */
        @media (max-width: 575px) {
            table th, table td {
                padding: 8px 10px;
                font-size: 11px;
            }
            .filter-form {
                flex-direction: column;
                gap: 5px;
            }
            .filter-form input, .filter-form button, .filter-form a {
                width: 100%;
                font-size: 12px;
                padding: 6px 10px;
            }
            .table-responsive {
                overflow-x: auto;
            }
        }
        td .btn-sm {
            padding: 4px 8px;
            font-size: 12px;
        }
        .table-responsive {
            overflow-x: auto;
        }


    </style>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/tr.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet"/>

    <script>
        flatpickr("#datetime", {
            locale: "tr",
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            allowInput: true,
        });
        flatpickr("#end_datetime", {
            locale: "tr",
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            allowInput: true,
        });





    </script>
    <div style="margin-top: 15px;">
        {{ $reservations->links('pagination::bootstrap-5') }}
    </div>


@endsection
