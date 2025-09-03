<form action="{{ route('table.pay', $reservation->id) }}" method="POST">
    @csrf
    <h2>Masa Ücreti Ödeme</h2>
    <p>Masa: {{ $reservation->table_id }}</p>
    <p>Tutar: {{ $reservation->total_price }} TL</p> <!-- Burada total_price kullanılacak -->

    <input type="text" name="card_holder_name" placeholder="Kart Sahibi Adı" required>
    <input type="text" name="card_number" placeholder="Kart Numarası" required>
    <input type="text" name="expire_month" placeholder="Ay" required>
    <input type="text" name="expire_year" placeholder="Yıl" required>
    <input type="text" name="cvc" placeholder="CVC" required>

    <button type="submit">Öde ve Rezervasyonu Onayla</button>
</form>
<style>
    /* Genel form alanları */
    form {
        max-width: 400px;
        margin: 40px auto;
        padding: 30px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        font-family: 'Arial', sans-serif;
    }

    /* Başlık */
    form h2 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    /* Masa ve tutar bilgisi */
    form p {
        font-size: 16px;
        color: #555;
        margin: 5px 0 15px 0;
        text-align: center;
    }

    /* Input alanları */
    form input[type="text"] {
        width: 100%;
        padding: 12px 15px;
        margin-bottom: 15px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 16px;
        transition: all 0.3s;
    }

    form input[type="text"]:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 5px rgba(13,110,253,0.3);
        outline: none;
    }

    /* Buton */
    form button {
        width: 100%;
        padding: 15px;
        background-color: #0d6efd;
        border: none;
        border-radius: 8px;
        color: #fff;
        font-size: 18px;
        cursor: pointer;
        transition: all 0.3s;
    }

    form button:hover {
        background-color: #0b5ed7;
        box-shadow: 0 5px 15px rgba(13,110,253,0.4);
    }

    /* Responsive */
    @media (max-width: 500px) {
        form {
            padding: 20px;
        }
        form h2 {
            font-size: 20px;
        }
    }
</style>
