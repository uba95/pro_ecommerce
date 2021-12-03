<?php

namespace App\Mail;

use App\Services\OrderService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $msg1 = $this->order->status == 'pending' ? 'placed' : 'updated';
        $msg2 = $this->order->status == 'pending' ? 'placed' : $this->order->status;
        $mail = $this->subject("[Order $msg1] Order #{$this->order->id} has been $msg2")->markdown('emails.order');

        if ($this->order->status == 'paid') {
            return $mail->attach(OrderService::saveInvoice($this->order));
        }

        return $mail;
    }
}
