<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReturnOrderMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $return_order_request;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($return_order_request)
    {
        $this->return_order_request = $return_order_request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $msg1 = $this->return_order_request->status == 'pending' ? 'received' : 'updated';
        $msg2 = $this->return_order_request->status == 'pending' ? 'received' : $this->return_order_request->status;
        return $this->subject("[Request $msg1] Return Order Request #{$this->return_order_request->id} has been $msg2")
        ->markdown('emails.return_order_request');
    }
}
