@extends('layouts.app')

@section('content')
    <style>
        .user-reservations {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            padding: 20px;
            background-color: #fdf6f0;
        }

        .user-reservations .card {
            width: 100%;
            max-width: 1000px;
            border-radius: 15px;
            overflow: hidden;
        }

        .user-reservations .card-header {
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
            background-color: #ff7f50;
            color: #fff;
            padding: 15px 0;
        }

        .reservation-row {
            display: flex;
            flex-wrap: wrap;
            border-bottom: 1px solid #ddd;
            background-color: #fff;
            margin-bottom: 10px;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .reservation-row:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .reservation-cell {
            flex: 1 1 20%;
            padding: 15px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 80px;
        }

        .reservation-cell:last-child {
            border-right: none;
        }

        .reservation-header {
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
            font-size: 0.95rem;
        }

        .reservation-value {
            font-size: 0.95rem;
            word-wrap: break-word;
        }

        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #fff;
        }
        .badge.pending { background-color: #f59e0b; }
        .badge.reserved { background-color: #3b82f6; }
        .badge.completed { background-color: #10b981; }
        .badge.approved { background-color: #10b981; }
        .badge.rejected { background-color: #f44336; }

        .reservation-details {
            display: none;
            padding: 15px;
            background-color: #f9fafb;
            border-top: 1px solid #ddd;
            border-radius: 0 0 10px 10px;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .detail-btn {
            margin-top: 10px;
            padding: 6px 12px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #fff;
            background-color: #ff7f50;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .detail-btn:hover { background-color: #ff5722; }

        .update-btn { background-color: #3b82f6; }
        .update-btn:hover { background-color: #2563eb; }

        .cancel-btn { background-color: #f44336; }
        .cancel-btn:hover { background-color: #d32f2f; }

        /* Responsive */
        @media (max-width: 768px) {
            .reservation-row { flex-direction: column; }
            .reservation-cell {
                flex: 1 1 100%;
                min-height: auto;
                border-right: none;
                border-bottom: 1px solid #eee;
            }
            .reservation-cell:last-child { border-bottom: none; }
        }
    </style>

    <div class="container user-reservations">
        <div class="card">
            <div class="card-header">Rezervasyonlarım</div>
            <div class="card-body p-4">
                @forelse($reservations as $reservation)
                    <div class="reservation-row" data-id="{{ $reservation->id }}">
                        <div class="reservation-cell">
                            <div class="reservation-header">Rezervasyon</div>
                            <div class="reservation-value">{{ $loop->iteration }}</div>
                        </div>
                        <div class="reservation-cell">
                            <div class="reservation-header">🪑 Masa</div>
                            <div class="reservation-value">{{ $reservation->table_id }}</div>
                        </div>
                        <div class="reservation-cell">
                            <div class="reservation-header">Ad</div>
                            <div class="reservation-value">{{ $reservation->name }}</div>
                        </div>
                        <div class="reservation-cell">
                            <div class="reservation-header">Soyad</div>
                            <div class="reservation-value">{{ $reservation->surname }}</div>
                        </div>
                        <div class="reservation-cell">
                            <div class="reservation-header">Durum</div>
                            <div>
                            <span class="badge {{ strtolower($reservation->status) }}">
                                {{ ucfirst($reservation->status) }}
                            </span>
                            </div>
                        </div>

                        <div class="reservation-cell" style="flex: 1 1 100%; margin-top:10px;">
                            <button class="detail-btn" onclick="toggleDetails(this)">Detayları Göster</button>
                            <div class="reservation-details">
                                <p><strong>Telefon:</strong> {{ $reservation->phone }}</p>
                                <p><strong>Email:</strong> {{ $reservation->email }}</p>
                                <p><strong>Tarih & Saat:</strong> {{ $reservation->datetime }}</p>
                                <p><strong>Mesaj:</strong> {{ $reservation->message ?? '-' }}</p>

                                <button class="detail-btn update-btn" data-bs-toggle="modal" data-bs-target="#updateModal{{ $reservation->id }}">Güncelle</button>
                                <button class="detail-btn cancel-btn" onclick="cancelReservation({{ $reservation->id }}, this)">İptal Et</button>

                                <div class="update-msg mt-2"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="updateModal{{ $reservation->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Rezervasyonu Güncelle</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label>Kişi Sayısı (Masa kapasitesi: {{ $reservation->table->capacity }})</label>
                                    <input type="number" class="form-control people-input" value="{{ $reservation->people }}" min="1" max="{{ $reservation->table->capacity }}">

                                    <label>Mesaj</label>
                                    <textarea class="form-control message-input">{{ $reservation->message }}</textarea>

                                    <div class="mt-3 text-end">
                                        <button class="btn btn-primary" onclick="updateReservation({{ $reservation->id }}, this)">Güncelle</button>
                                    </div>
                                    <div class="update-msg mt-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    <p class="text-center py-5 text-gray-600">Henüz rezervasyonunuz yok.</p>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        function toggleDetails(btn) {
            const details = btn.nextElementSibling;
            if(details.style.display === 'block') {
                details.style.display = 'none';
                btn.innerText = 'Detayları Göster';
            } else {
                details.style.display = 'block';
                btn.innerText = 'Detayları Gizle';
            }
        }

        function updateReservation(id, btn) {
            const modal = btn.closest('.modal');
            const people = modal.querySelector('.people-input').value;
            const message = modal.querySelector('.message-input').value;
            const msgDiv = modal.querySelector('.update-msg');

            fetch(`/my-reservations/${id}/update`, {
                method: 'POST',
                headers: {
                    'Content-Type':'application/json',
                    'X-CSRF-TOKEN':'{{ csrf_token() }}'
                },
                body: JSON.stringify({ people, message })
            })
                .then(res => res.json())
                .then(data => {
                    msgDiv.innerText = data.message;
                    msgDiv.style.color = data.success ? 'green' : 'red';
                    if(data.success){
                        setTimeout(()=> {
                            const modalEl = bootstrap.Modal.getInstance(modal);
                            modalEl.hide();
                            location.reload();
                        }, 800);
                    }
                });
        }

        function cancelReservation(id, btn) {
            if(!confirm('Rezervasyonu iptal etmek istediğinize emin misiniz?')) return;

            const row = btn.closest('.reservation-row');
            const msgDiv = row.querySelector('.update-msg');

            fetch(`/my-reservations/${id}/cancel`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN':'{{ csrf_token() }}'
                }
            })
                .then(res => res.json())
                .then(data => {
                    msgDiv.innerText = data.message;
                    msgDiv.style.color = 'red';
                    row.style.opacity = 0.5;
                });
        }
    </script>
@endsection
