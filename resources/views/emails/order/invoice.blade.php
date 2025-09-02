<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
</head>
<body>

<p>Merhaba {{ $order->reservation->name ?? 'Müşteri' }},</p>
<p>Siparişinizin faturası ekte yer almaktadır.</p>
<p>Toplam: <strong>{{ number_format($order->total_price,2) }} TL</strong></p>
<p>PDF içindeki Detayları görebilirsiniz.</p>
<p>Teşekkürler!</p>

</body>
</html>
