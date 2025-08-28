<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Rezervasyon Onayı</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
<div style="max-width: 600px; margin: auto; background-color: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    <h2 style="color: #333;">Merhaba {{ $reservation->user?->name ?? 'Müşteri' }},</h2>

    <p style="color: #555; font-size: 16px;">
        Rezervasyonunuz başarıyla alındı! Detaylar aşağıda yer almaktadır:
    </p>

    <table style="width: 100%; border-collapse: collapse; margin: 15px 0;">
        <tr>
            <td style="padding: 8px; font-weight: bold;">Rezervasyon ID:</td>
            <td style="padding: 8px;">{{ $reservation->id }}</td>
        </tr>
        <tr style="background-color: #f9f9f9;">
            <td style="padding: 8px; font-weight: bold;">Rezervasyon Tarihi:</td>
            <td style="padding: 8px;">{{ \Carbon\Carbon::parse($reservation->datetime)->format('d-m-Y H:i') }}</td>
        </tr>
    </table>

    <p style="text-align: center; margin: 20px 0;">
        <a href="{{ route('reservation.preorder', $reservation->preorder_token) }}"
           style="background-color: #28a745; color: #fff; padding: 12px 20px; text-decoration: none; border-radius: 6px; font-weight: bold;">
            Ön Sipariş Yap
        </a>
    </p>

    <p style="color: #777; font-size: 14px; text-align: center;">
        Restoranımızda sizi ağırlamaktan mutluluk duyacağız!
    </p>
</div>
</body>
</html>
