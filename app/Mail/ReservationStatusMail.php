<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ReservationStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $qrCode;

    // Constructor ile rezervasyon bilgisini alıyoruz
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;

        // PNG base64 QR kod oluşturuyoruz
        $this->qrCode = base64_encode(
            QrCode::format('png')
                ->size(200)
                ->generate(url('/dashboard/reservations/' . $reservation->id))
        );
    }

    // Mail içeriği ve başlığı burada belirlenir
    public function build()
    {
        return $this->subject('Rezervasyon Durum Güncellemesi')
            ->view('emails.reservation.status')
            ->with([
                'qrCode' => $this->qrCode,
            ]);
    }
}
