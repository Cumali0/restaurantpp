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

    // Constructor ile rezervasyon bilgisini alıyoruz
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    // Mail içeriği ve başlığı burada belirlenir
    public function build()
    {
        $qrCode = QrCode::format('svg')->size(150)->generate(url('/dashboard/reservations/' . $this->reservation->id));

        return $this->subject('Rezervasyon Durum Güncellemesi')
            ->view('emails.reservation.status') // Markdown view dosyamızın yolu
            ->with([
                'qrCode' => $qrCode,
            ]);
    }
}
