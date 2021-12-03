<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReplyContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contactMessage;
    public $reply;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message, $reply)
    {
        $this->contactMessage = $message;
        $this->reply = $reply;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->reply->subject)->view('emails.reply_contact');
    }
}
