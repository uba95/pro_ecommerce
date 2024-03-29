<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Mail\ContactMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index() {
        return view('pages.contact');
    }

    public function store(ContactRequest $request) {

        Contact::create(Arr::except($request->validated(), 'g-recaptcha-response'));
        Mail::to($request->email)->send(new ContactMail($request->name));

        return redirect()->route('pages.landing_page.index')->with(toastNotification('Your Message Has Been Successfully Sent'));
    }
}
