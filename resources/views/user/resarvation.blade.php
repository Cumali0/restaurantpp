@extends('layouts.app') <!-- Header ve Footer layouts.app içinde olacak -->

@section('content')
    <style>
        /* ---------------------------
   USER RESERVATIONS STYLING
---------------------------- */
        .user-reservations {
            display: flex;
            justify-content: center; /* yatay ortala */
            align-items: center;     /* dikey ortala */
            min-height: 80vh;        /* ekranın çoğunu kaplasın */
            padding: 20px;
        }

        .user-reservations .card {
            width: 100%;
            max-width: 900px; /* genişliği sınırladık */
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            border-radius: 12px;
            overflow: hidden;
        }

        .user-reservations .card-header {
            font-size: 1.4rem;
            font-weight: 600;
            text-align: center;
            letter-spacing: 1px;
        }

        .user-reservations table {
            width: 100%;
            border-collapse: collapse;
        }

        .user-reservations th,
        .user-reservations td {
            padding: 12px 15px;
            text-align: center;
            vertical-align: middle;
        }

        .user-reservations th {
            background-color: #007bff;
            color: #fff;
            font-weight: 500;
        }

        .user-reservations tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .user-reservations tbody tr:hover {
            background-color: #e2f0ff;
            transition: 0.3s;
        }

        .user-reservations td {
            font-size: 0.95rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .user-reservations .card {
                max-width: 100%;
            }

            .user-reservations table,
            .user-reservations thead,
            .user-reservations tbody,
            .user-reservations th,
            .user-reservations td,
            .user-reservations tr {
                display: block;
            }

            .user-reservations thead tr {
                display: none;
            }

            .user-reservations tbody tr {
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 10px;
            }

            .user-reservations td {
                text-align: right;
                padding-left: 50%;
                position: relative;
            }

            .user-reservations td::before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                width: 45%;
                padding-left: 5px;
                font-weight: 600;
                text-align: left;
            }
        }

    </style>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h2 class="mb-4 text-center">Merhaba, {{ auth()->user()->name }}</h2>

                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        Rezervasyonlarım
                    </div>
                    <div class="card-body" style="margin-left: 480px;
    display: flex
;
    flex-direction: column;">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Masa</th>
                                <th>Ad</th>
                                <th>Soyad</th>
                                <th>Telefon</th>
                                <th>Email</th>
                                <th>Tarih & Saat</th>
                                <th>Kişi Sayısı</th>
                                <th>Mesaj</th>
                                <th>Durum</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($reservations as $reservation)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $reservation->table_id }}</td>
                                    <td>{{ $reservation->name }}</td>
                                    <td>{{ $reservation->surname }}</td>
                                    <td>{{ $reservation->phone }}</td>
                                    <td>{{ $reservation->email }}</td>
                                    <td>{{ $reservation->datetime }}</td>
                                    <td>{{ $reservation->people }}</td>
                                    <td>{{ $reservation->message }}</td>
                                    <td>{{ $reservation->status }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">Henüz rezervasyonunuz yok.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
