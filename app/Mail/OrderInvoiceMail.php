<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;


class OrderInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $pdfContent;

    public function __construct(Order $order)
    {
        $this->order = $order;


        // PDF oluştur
        $this->pdfContent = Pdf::loadView('orders.invoice', [
            'order' => $order,
        ])->setPaper([0, 0, 300, 600], 'portrait')->output();
    }

    public function build()
    {
        return $this->subject('Sipariş Faturanız')
            ->view('emails.order.invoice')
            ->attachData($this->pdfContent, 'fatura_'.$this->order->id.'.pdf', [
                'mime' => 'application/pdf',
            ])
            ->with([
                'order' => $this->order
            ]);
    }
}
