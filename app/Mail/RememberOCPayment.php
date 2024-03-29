<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RememberOCPayment extends Mailable
{
    use Queueable, SerializesModels;

    public $orders;
    public $subject = 'Recordatorio de pago Ordenes de compra';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orders)
    {
       $this->orders = $orders;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.rememberocpayment')->with(['orders', $this->orders]);
    }
}
