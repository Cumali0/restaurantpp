<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>Rezervasyon Durumu</title>
</head>
<body style="margin:0; padding:20px; background-color:#f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color:#333;">
<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center">
            <table width="600" style="background-color:#fff; padding:40px; border-radius:8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                <tr>
                    <td>
                        <h2 style="font-weight:600; font-size:24px; margin-bottom:30px; border-bottom: 2px solid #2575fc; padding-bottom:10px;">
                            Merhaba {{ $reservation->name }},
                        </h2>

                        <p style="font-size:16px; line-height:1.5; margin-bottom:20px;">
                            Rezervasyonunuzun durumu güncellenmiştir.
                        </p>

                        <p style="font-size:16px; margin:5px 0;">
                            <strong>Durum:</strong> {{ ucfirst($reservation->status) }}
                        </p>
                        <p style="font-size:16px; margin:5px 0 20px 0;">
                            <strong>Rezervasyon Tarihi:</strong> {{ \Carbon\Carbon::parse($reservation->datetime)->format('d-m-Y H:i') }}
                        </p>

                        @if($reservation->status === 'approved')
                            <p style="color:#2e7d32; font-weight:bold; margin-bottom:30px;">
                                Rezervasyonunuz onaylanmıştır. Sizi ağırlamaktan mutluluk duyarız!
                            </p>
                        @elseif($reservation->status === 'rejected')
                            <p style="color:#d32f2f; font-weight:bold; margin-bottom:30px;">
                                Maalesef rezervasyonunuz reddedilmiştir. Anlayışınız için teşekkür ederiz.
                            </p>
                        @endif

                        <div style="text-align:center; margin-bottom:30px;">
                            <a href="{{ route('reservation.thankyou') }}"
                               style="background-color:#2575fc; color:#fff; padding:12px 28px; border-radius:5px; text-decoration:none; font-weight:600; font-size:16px; display:inline-block;">
                                Ana Sayfa
                            </a>
                        </div>

                        {{-- QR KODU BURAYA EKLENDİ --}}
                        <div style="text-align:center; margin:20px 0;">
                            {!! $qrCode !!}
                            <p style="font-size:14px; color:#666;">Rezervasyon detaylarınızı QR kodu okutup görüntüleyebilirsiniz.</p>
                        </div>
                        <p style="font-size:14px; color:#777; border-top:1px solid #eee; padding-top:15px;">
                            Saygılarımızla,<br />
                            <strong>{{ config('app.name') }}</strong>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
