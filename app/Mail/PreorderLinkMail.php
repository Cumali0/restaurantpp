<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PreorderLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function build()
    {
        $url = route('reservation.preorder', ['token' => $this->token]);

        return $this->subject('Yarım Kalan Siparişinizi Tamamlayın')
            ->view('emails.preorder_link')
            ->with([
                'url' => $url,
            ]);
    }
}
