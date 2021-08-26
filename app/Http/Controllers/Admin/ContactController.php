<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ReplyContact as MailReplyContact;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function __construct() {
        $this->middleware('can:view contact messages',      ['only' => ['index', 'show']]);
        $this->middleware('can:reply contact messages',     ['only' => ['reply', 'update']]);    
        $this->middleware('can:delete contact messages',    ['only' => ['delete']]);    
    }

    public function index() {
        return view('admin.contact-messages.index', ['messages' => Contact::all()]);
    }

    public function show(Contact $message) {
        return view('admin.contact-messages.show', compact('message'));
    }

    public function reply(Contact $message) {
        return view('admin.contact-messages.reply', compact('message'));
    }

    public function update(Contact $message, Request $request) {

        $reply = $request->validate(['reply' => 'required', 'subject' => 'required']);
        Mail::to($message->email)->send(new MailReplyContact($message, (object) $reply));
        $message->update(['replied' => true]);

        return redirect()->route('admin.contact.messages.index')->with(toastNotification('Reply Has Been Successfully Sent'));
    }

    public function destroy(Contact $message) {
        $message->delete();
        return redirect()->route('admin.contact.messages.index')->with(toastNotification('Message', 'deleted'));
    }
}