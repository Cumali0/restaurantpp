@extends('layouts.app')

@section('content')
    <div style="min-height:100vh; display:flex; justify-content:center; align-items:center; background:#f2f2f2; padding:20px;">
        <div style="max-width:450px; width:100%; background:#ffffff; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1); padding:30px; position:relative; font-family:Arial, sans-serif; transition:0.3s;">
            <h2 style="text-align:center; margin-bottom:20px; color:#333; font-weight:600;">Ödeme Sayfası</h2>

            <p><strong>Order ID:</strong> {{ $order->id }}</p>
            <p><strong>Toplam Tutar:</strong> {{ number_format($order->total_price,2) }}₺</p>

            <h3 style="margin-top:20px; color:#333;">Ödeme Bilgileri</h3>
            <form id="payment-form" style="display:flex; flex-direction:column; gap:15px; transition:0.3s;">
                <!-- Ödeme Yöntemi -->
                <div>
                    <label><input type="radio" name="payment_method" value="banka" checked> Banka Kartı</label>
                    <label style="margin-left:15px;"><input type="radio" name="payment_method" value="kredi"> Kredi Kartı</label>
                </div>

                <!-- Minimalist Kart Görseli -->
                <div id="card-visual" style="display:flex; margin:15px 0; padding:20px; border-radius:12px; background:linear-gradient(135deg,#2c3e50,#34495e); color:white; font-family:monospace; height:140px; position:relative; box-shadow:0 4px 15px rgba(0,0,0,0.2); transition:0.3s;">

                    <!-- Kart tipi ikonu -->
                    <div id="card-type-icon" style="position:absolute; top:15px; right:20px; font-size:20px;">🏦</div>

                    <div style="position:absolute; top:15px; left:20px; font-size:12px; letter-spacing:1px;">KART SAHİBİ</div>
                    <div id="card-name" style="position:absolute; top:35px; left:20px; font-size:16px; font-weight:bold;">John Doe</div>
                    <div id="card-number-display" style="position:absolute; bottom:50px; left:20px; font-size:16px; letter-spacing:2px;">**** **** **** ****</div>
                    <div style="position:absolute; bottom:20px; left:20px; font-size:10px;">AA/YY</div>
                    <div id="card-expiry" style="position:absolute; bottom:20px; left:55px; font-size:10px;">--/--</div>
                    <div style="position:absolute; bottom:20px; right:20px; font-size:10px;">CVV</div>
                    <div id="card-cvv" style="position:absolute; bottom:20px; right:50px; font-size:10px;">***</div>
                </div>

                <!-- Kart Alanları -->
                <div id="card-fields" style="display:flex; flex-direction:column; gap:10px;">
                    <input type="text" name="card_number" placeholder="Kart Numarası (16 hane)" maxlength="16" style="padding:10px; border-radius:6px; border:1px solid #ccc; font-size:14px;">
                    <div style="display:flex; gap:10px;">
                        <input type="text" name="expiry" placeholder="AA/YY" maxlength="5" style="flex:1; padding:10px; border-radius:6px; border:1px solid #ccc; font-size:14px;">
                        <input type="text" name="cvv" placeholder="CVV" maxlength="3" style="flex:1; padding:10px; border-radius:6px; border:1px solid #ccc; font-size:14px;">
                    </div>
                    <input type="text" name="card_name" placeholder="Kart Sahibi Adı" style="padding:10px; border-radius:6px; border:1px solid #ccc; font-size:14px;">
                </div>

                <button type="submit" style="padding:12px; background:#34495e; color:white; border:none; border-radius:6px; cursor:pointer; font-weight:bold; font-size:15px; transition:0.3s;">Ödemeyi Tamamla</button>
            </form>

            <div id="success-message" style="display:none; margin-top:20px; text-align:center; color:#27ae60; font-weight:bold; font-size:16px; transition:0.3s;">
                Ödeme başarılı! Teşekkürler.
            </div>

            <!-- Spinner -->
            <div id="spinner" style="display:none; margin:20px auto 0; width:40px; height:40px; border:4px solid #ccc; border-top:4px solid #27ae60; border-radius:50%; animation:spin 1s linear infinite;"></div>
        </div>
    </div>

    <style>
        #card-visual {
            display:flex;
            margin:15px 0;
            padding:20px;
            border-radius:12px;
            background:linear-gradient(135deg,#2c3e50,#34495e);
            color:white;
            font-family:monospace;
            height:160px;
            position:relative;
            box-shadow:0 8px 20px rgba(0,0,0,0.3);
            transition: all 0.5s ease;
            transform-style: preserve-3d;
            perspective: 1000px;
        }

        #card-visual.flip {
            transform: rotateY(180deg);
        }

        #card-type-icon {
            position:absolute;
            top:15px;
            right:20px;
            font-size:24px;
            transition: all 0.3s ease;
        }

        #card-fields input {
            transition: all 0.3s ease;
        }

        #card-number-display, #card-name, #card-expiry, #card-cvv {
            transition: all 0.3s ease;
        }

        /* Hover ve ışık efekti */
        #card-visual:hover {
            box-shadow: 0 16px 40px rgba(0,0,0,0.5), 0 0 30px rgba(255,255,255,0.1) inset;
        }

        /* Kart üzerine hafif ışık yansıması */
        #card-visual::before {
            content: "";
            position: absolute;
            top:0; left:0;
            width:100%; height:100%;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(255,255,255,0.15), rgba(0,0,0,0) 70%);
            pointer-events: none;
            z-index:1;
        }





        /* Temel body ayarları */
        body {
            font-family: 'Arial', sans-serif;
            background: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Form kapsayıcı */
        .payment-container {
            max-width: 500px;
            width: 100%;
            background: #ffffff;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
            transition: all 0.3s ease;
        }

        /* Başlıklar */
        .payment-container h2 {
            text-align: center;
            color: #333;
            font-weight: 700;
            margin-bottom: 25px;
            font-size: 26px;
        }

        .payment-container h3 {
            color: #333;
            margin: 25px 0 15px 0;
            font-size: 20px;
        }

        /* Ödeme yöntemi */
        .payment-methods {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .payment-methods input[type="radio"] {
            margin-right: 8px;
        }

        /* Kart görsel kapsayıcı */
        .card-visual {
            position: relative;
            height: 180px;
            border-radius: 16px;
            perspective: 1200px;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #2c3e50, #34495e);
            box-shadow: 0 12px 40px rgba(0,0,0,0.3);
            transition: all 0.5s ease;
        }

        /* Kart iç animasyonları */
        .card-inner {
            width: 100%;
            height: 100%;
            border-radius: 16px;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.6s ease;
        }

        /* Ön yüz */
        .card-front, .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 16px;
            backface-visibility: hidden;
            color: white;
            padding: 20px;
            box-sizing: border-box;
        }

        /* Ön yüz detayları */
        .card-front {
            background: linear-gradient(135deg, #2c3e50, #34495e);
        }

        .card-front .chip {
            width: 40px;
            height: 30px;
            background: #d4af37;
            border-radius: 6px;
            position: absolute;
            top: 40px;
            left: 20px;
        }

        .card-front .card-type {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 24px;
            transition: all 0.3s ease;
        }

        .card-front .card-number {
            position: absolute;
            bottom: 50px;
            left: 20px;
            font-size: 18px;
            letter-spacing: 2px;
            transition: all 0.3s ease;
        }

        .card-front .card-name {
            position: absolute;
            top: 35px;
            left: 20px;
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        .card-front .card-expiry {
            position: absolute;
            bottom: 20px;
            left: 50px;
            font-size: 12px;
        }

        /* Arka yüz */
        .card-back {
            background: linear-gradient(135deg, #34495e, #2c3e50);
            transform: rotateY(180deg);
        }

        .card-back .magnetic-strip {
            position: absolute;
            top: 40px;
            left: 0;
            width: 100%;
            height: 40px;
            background: black;
        }

        .card-back .cvv {
            position: absolute;
            bottom: 50px;
            right: 50px;
            font-size: 14px;
            letter-spacing: 2px;
        }

        /* Kart inputları */
        .card-fields {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 20px;
        }

        .card-fields input {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .card-fields input:focus {
            border-color: #27ae60;
            box-shadow: 0 0 8px rgba(39,174,96,0.5);
            outline: none;
        }

        /* Buton */
        .payment-btn {
            padding: 14px;
            border-radius: 8px;
            border: none;
            background: #34495e;
            color: white;
            font-weight: bold;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .payment-btn:hover {
            background: #2c3e50;
        }

        /* Spinner */
        .spinner {
            display: none;
            margin: 20px auto 0;
            width: 45px;
            height: 45px;
            border: 4px solid #ccc;
            border-top: 4px solid #27ae60;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin { 0%{transform:rotate(0deg);}100%{transform:rotate(360deg);} }

        /* Animasyonlar */
        @keyframes blink { 0%,100%{opacity:1;}50%{opacity:0.3;} }
        .blink { animation: blink 0.5s infinite; }

        @keyframes shake { 0%,100%{transform:translateX(0);}20%,60%{transform:translateX(-5px);}40%,80%{transform:translateX(5px);} }
        .shake { animation: shake 0.5s; }

        /* Hover efektleri */
        .card-visual:hover {
            box-shadow: 0 16px 40px rgba(0,0,0,0.5), 0 0 30px rgba(255,255,255,0.1) inset;
        }

        .card-visual::before {
            content:"";
            position:absolute;
            top:0; left:0;
            width:100%; height:100%;
            border-radius:16px;
            background: linear-gradient(135deg, rgba(255,255,255,0.15), rgba(0,0,0,0) 70%);
            pointer-events:none;
            z-index:1;
        }

        /* ===== Responsive ===== */

        /* Tablet */
        @media screen and (max-width: 900px) {
            .payment-container {
                padding: 30px;
            }
            .card-fields input { font-size: 13px; padding: 10px; }
            .payment-btn { font-size: 15px; padding: 12px; }
            .card-visual { height: 160px; }
            .card-front .card-number { font-size: 16px; }
        }

        /* Mobil */
        @media screen and (max-width: 600px) {
            .payment-container { padding: 25px; }
            .card-fields input { font-size: 12px; padding: 8px; }
            .payment-btn { font-size: 14px; padding: 10px; }
            .card-visual { height: 140px; }
            .card-front .card-number { font-size: 14px; }
            .card-front .card-name { font-size: 14px; }
            .card-front .card-expiry { font-size: 10px; }
            .card-back .cvv { font-size: 12px; right: 30px; }
        }

        /* Küçük mobil */
        @media screen and (max-width: 400px) {
            .payment-container { padding: 20px; }
            .card-fields input { font-size: 11px; padding: 6px; }
            .payment-btn { font-size: 13px; padding: 8px; }
            .card-visual { height: 120px; }
            .card-front .card-number { font-size: 12px; }
            .card-front .card-name { font-size: 12px; }
            .card-front .card-expiry { font-size: 9px; }
        }




    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
            const cardFields = document.getElementById('card-fields');
            const cardVisual = document.getElementById('card-visual');
            const form = document.getElementById('payment-form');
            const successMessage = document.getElementById('success-message');
            const spinner = document.getElementById('spinner');
            const cardTypeIcon = document.getElementById('card-type-icon');

            const cardNumberDisplay = document.getElementById('card-number-display');
            const cardExpiry = document.getElementById('card-expiry');
            const cardCVV = document.getElementById('card-cvv');
            const cardName = document.getElementById('card-name');

            // Sayfa açıldığında banka kartı alanını göster
            cardFields.style.display = 'flex';
            cardVisual.style.display = 'flex';
            cardTypeIcon.textContent = '🏦';

            paymentRadios.forEach(radio => {
                radio.addEventListener('change', () => {
                    cardVisual.classList.add('flip'); // animasyonlu geçiş

                    setTimeout(() => {
                        cardVisual.classList.remove('flip');

                        if(radio.value === 'banka'){
                            cardTypeIcon.textContent = '🏦';
                        } else if(radio.value === 'kredi'){
                            cardTypeIcon.textContent = '💳';
                        }

                        cardFields.style.display = 'flex';
                        cardVisual.style.display = 'flex';
                    }, 250); // flip süresi
                });
            });

            // Kart bilgilerini canlı göster
            form.card_number?.addEventListener('input', e => {
                let val = e.target.value.padEnd(16,'*');
                cardNumberDisplay.textContent = val.replace(/(.{4})/g, '$1 ').trim();
            });
            form.expiry?.addEventListener('input', e => cardExpiry.textContent = e.target.value || '--/--');
            form.cvv?.addEventListener('input', e => cardCVV.textContent = e.target.value.replace(/./g,'*') || '***');
            form.card_name?.addEventListener('input', e => cardName.textContent = e.target.value || 'John Doe');

            // Ödeme işlemi
            form.addEventListener('submit', function(e){
                e.preventDefault();
                const method = document.querySelector('input[name="payment_method"]:checked').value;

                if(method === 'banka' || method === 'kredi'){
                    const cardNumber = form.card_number.value.trim();
                    const expiry = form.expiry.value.trim();
                    const cvv = form.cvv.value.trim();
                    const name = form.card_name.value.trim();
                    if(cardNumber.length !== 16 || cvv.length !== 3 || expiry.length !== 5 || !name){
                        alert('Kart bilgilerini doğru giriniz!');
                        return;
                    }
                }

                form.style.display = 'none';
                spinner.style.display = 'block';
                successMessage.textContent = 'Ödeme işleniyor... Lütfen bekleyin.';
                successMessage.style.display = 'block';

                setTimeout(() => {
                    spinner.style.display = 'none';
                    successMessage.textContent = 'Ödeme başarılı! Teşekkürler.';
                }, 3000);
            });
        });
    </script>

@endsection
