@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <div class="card w-100">
            <div class="card-body">
                <div class="table-page">
                    <h2 style="text-align:center; font-size: 28px; margin-bottom: 30px;">🍽️ Masa Yönetimi</h2>

                    <div style="margin-bottom: 20px;">
                        <button class="btn btn-success" onclick="openAddModal()">➕ Yeni Masa Ekle</button>
                    </div>

                    <form method="GET" action="{{ route('tables.index') }}" class="d-flex gap-2 mb-3 align-items-center">

                        <select name="capacity" class="form-control" style="width: 150px;">
                            <option value="">Kapasite (Tümü)</option>
                            @foreach($capacities as $capacity)
                                <option value="{{ $capacity }}" {{ request('capacity') == $capacity ? 'selected' : '' }}>{{ $capacity }}</option>
                            @endforeach
                        </select>

                        <select name="floor" class="form-control" style="width: 150px;">
                            <option value="">Kat (Tümü)</option>
                            @foreach($floors as $floor)
                                <option value="{{ $floor }}" {{ request('floor') == $floor ? 'selected' : '' }}>{{ $floor }}</option>
                            @endforeach
                        </select>

                        <button type="submit" class="btn btn-primary btn-sm">Filtrele</button>
                        <a href="{{ route('tables.index') }}" class="btn btn-secondary btn-sm">Temizle</a>

                    </form>


                    {{-- Masalar Tablosu --}}
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ad</th>
                            <th>Kapasite</th>
                            <th>Kat</th>
                            <th>İşlemler</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tables as $table)
                            <tr>
                                <td>{{ $table->id }}</td>
                                <td>{{ $table->name }}</td>
                                <td>{{ $table->capacity }}</td>
                                <td>{{ $table->floor }}</td>
                                <td>
                                    <button class="btn btn-info btn-sm" onclick="openReservationsModal({{ $table->id }}, '{{ $table->name }}')">
                                        📋 Detay
                                    </button>

                                    <button class="btn btn-warning btn-sm"
                                            onclick="openEditModal({{ $table->id }}, '{{ $table->name }}', {{ $table->capacity }}, {{ $table->floor ?? 'null' }})">
                                        ✏ Düzenle
                                    </button>

                                    <form action="{{ route('tables.destroy', $table->id) }}" method="POST" class="inline-form" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Masa silinsin mi?')">🗑 Sil</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Rezervasyon Modal -->
                <div class="modal" id="reservationsModal" style="display:none;">
                    <div class="modal-content" style="max-width: 600px; background:white; padding:15px; border-radius:10px;">
                        <h3 id="reservationsTitle">Rezervasyonlar</h3>

                        <form id="reservationFilterForm" style="display: flex; gap: 10px; margin-bottom: 10px; flex-wrap: wrap;">
                            <input type="hidden" id="filterTableId" name="table_id">
                            <input type="date" id="filterDate" name="date">
                            <input type="time" id="filterStartTime" name="start_time">
                            <input type="time" id="filterEndTime" name="end_time">
                            <button type="submit" class="btn btn-primary btn-sm">Filtrele</button>
                        </form>

                        <div id="reservationsList">
                            Yükleniyor...
                        </div>

                        <div class="modal-buttons" style="margin-top: 15px;">
                            <button type="button" class="btn btn-secondary" onclick="closeReservationsModal()">Kapat</button>
                        </div>
                    </div>
                </div>





        <!-- Modal Yapıları -->
        <div class="modal" id="addModal" style="display:none;">
            <div class="modal-content">
                <h3>Yeni Masa Ekle</h3>
                <form action="{{ route('tables.store') }}" method="POST" class="modal-form">
                    @csrf
                    <input type="text" name="name" placeholder="Masa Adı" required />
                    <input type="number" name="capacity" placeholder="Kapasite" required />
                    <input type="number" name="floor" placeholder="Kat" />
                    <div class="modal-buttons">
                        <button type="submit" class="btn btn-success">Kaydet</button>
                        <button type="button" class="btn btn-secondary" onclick="closeAddModal()">İptal</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal" id="editModal" style="display:none;">
            <div class="modal-content">
                <h3>Masa Düzenle</h3>
                <form id="editForm" method="POST" class="modal-form">
                    @csrf
                    @method('PUT')
                    <input type="text" id="editName" name="name" required />
                    <input type="number" id="editCapacity" name="capacity" required />
                    <input type="number" id="editFloor" name="floor" />
                    <div class="modal-buttons">
                        <button type="submit" class="btn btn-primary">Güncelle</button>
                        <button type="button" class="btn btn-secondary" onclick="closeEditModal()">İptal</button>
                    </div>
                </form>
            </div>
        </div>

            </div>
        </div>
    </div>

    <style>
        /* Genel sayfa stili */
        .table-page {
            padding: 20px;
            background: #f9f9f9;
            border-radius: 10px;
        }

        .table-page h2 {
            margin-bottom: 20px;
            color: #333;
        }

        /* Butonlar */
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            user-select: none;
        }

        .btn-primary {
            background-color: #4b6cb7;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #3a54a1;
        }

        .btn-success {
            background-color: #28a745;
            color: #fff;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-sm {
            padding: 4px 10px;
            font-size: 0.85rem;
        }

        /* Tablo stili */
        .table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 6px rgb(0 0 0 / 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead tr {
            background-color: #4b6cb7;
            color: white;
            text-align: left;
        }

        .table th, .table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Status badge */
        .status-badge {
            padding: 4px 10px;
            border-radius: 15px;
            font-weight: 600;
            font-size: 0.9rem;
            color: #fff;
            text-transform: capitalize;
            display: inline-block;
        }

        .status-badge.available {
            background-color: #28a745;
        }

        .status-badge.booked {
            background-color: #dc3545;
        }

        /* Inline form (sil butonu için) */
        .inline-form {
            display: inline;
        }

        /* Modal stili */
        .modal {
            position: fixed;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            background: rgba(0, 0, 0, 0.45);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: #fff;
            padding: 25px 30px;
            border-radius: 12px;
            width: 380px;
            box-shadow: 0 5px 15px rgb(0 0 0 / 0.3);
        }

        .modal-content h3 {
            margin-bottom: 20px;
            color: #222;
            font-weight: 700;
            text-align: center;
        }

        .modal-form input,
        .modal-form select {
            width: 100%;
            padding: 8px 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .modal-form input:focus,
        .modal-form select:focus {
            outline: none;
            border-color: #4b6cb7;
        }

        .modal-buttons {
            display: flex;
            justify-content: space-between;
        }

        .modal-buttons button {
            width: 48%;
        }

        /* Alert mesajı */
        .success-alert {
            background-color: #d4edda;
            color: #155724;
            border-left: 5px solid #28a745;
            padding: 10px 15px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        /* Toggle Butonları */
        .view-toggle {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .btn-secondary.active {
            background-color: #4b6cb7;
            color: white;
        }

        /* Görsel Masa Grid */
        .tables-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .table-icon {
            width: 80px;
            height: 80px;
            background-color: #28a745;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: bold;
            font-size: 18px;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .table-icon.booked {
            background-color: #dc3545;
        }
        .table-icon:hover {
            transform: scale(1.1);
        }

        .table-page {
            margin: 0 auto;
        }

        .table {
            width: 100%;
            min-width: 100%;
        }

        .card {
            width: 415%;
            max-width: 415%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
            padding: 55px;
        }

        .table-page {
            padding: 20px;
            background: #f9f9f9;
            border-radius: 10px;
            max-width: 100%;
            width: 100%;
        }

        form {
            justify-content: center;
        }

    </style>

    {{-- JavaScript Kodları --}}
    <script>
        function openAddModal() {
            document.getElementById('addModal').style.display = 'flex';
        }
        function closeAddModal() {
            document.getElementById('addModal').style.display = 'none';
        }

        function openEditModal(id, name, capacity, floor) {
            document.getElementById('editModal').style.display = 'flex';
            document.getElementById('editName').value = name;
            document.getElementById('editCapacity').value = capacity;
            document.getElementById('editFloor').value = floor || '';
            document.getElementById('editForm').action = `/admin/tables/${id}`;
        }
        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }



        function openReservationsModal(tableId, tableName) {
            document.getElementById('reservationsTitle').innerText = "Masa " + tableName + " Rezervasyonları";
            document.getElementById('filterTableId').value = tableId;

            fetchReservations(tableId); // İlk açıldığında rezervasyonları getir
            document.getElementById('reservationsModal').style.display = 'block';
        }

        function closeReservationsModal() {
            document.getElementById('reservationsModal').style.display = 'none';
        }

        function fetchReservations(tableId, filters = {}) {
            let url = `/admin/tables/${tableId}/reservations`;



            // Filtre parametreleri ekleme
            let params = new URLSearchParams(filters).toString();
            if (params) {
                url += `?${params}`;
            }

            fetch(url)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('reservationsList').innerHTML = html;
                })
                .catch(() => {
                    document.getElementById('reservationsList').innerHTML = "Hata oluştu.";
                });
        }

        // Filtre formu submit olunca çalışır
        document.getElementById('reservationFilterForm').addEventListener('submit', function (e) {
            e.preventDefault();
            let tableId = document.getElementById('filterTableId').value;
            let filters = {
                date: document.getElementById('filterDate').value,
                start_time: document.getElementById('filterStartTime').value,
                end_time: document.getElementById('filterEndTime').value
            };
            fetchReservations(tableId, filters);
        });
    </script>
@endsection
