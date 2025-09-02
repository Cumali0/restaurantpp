<form action="{{ route('table.pay', $reservation->id) }}" method="POST">
    @csrf
    <h2>Masa Ücreti Ödeme</h2>
    <p>Masa: {{ $reservation->table_id }}</p>
    <p>Tutar: {{ $reservation->table_price }} TL</p>

    <input type="text" name="card_holder_name" placeholder="Kart Sahibi Adı" required>
    <input type="text" name="card_number" placeholder="Kart Numarası" required>
    <input type="text" name="expire_month" placeholder="Ay" required>
    <input type="text" name="expire_year" placeholder="Yıl" required>
    <input type="text" name="cvc" placeholder="CVC" required>

    <button type="submit">Öde ve Rezervasyonu Onayla</button>
</form>
