<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CancelOrderMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $cancel_order_request;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cancel_order_request)
    {
        $this->cancel_order_request = $cancel_order_request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $msg1 = $this->cancel_order_request->status == 'pending' ? 'received' : 'updated';
        $msg2 = $this->cancel_order_request->status == 'pending' ? 'received' : $this->cancel_order_request->status;
        return $this->subject("[Request $msg1] Cancel Order Request #{$this->cancel_order_request->id} has been $msg2")
        ->markdown('emails.cancel_order_request');
    }
}
