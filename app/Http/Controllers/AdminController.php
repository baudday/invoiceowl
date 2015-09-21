<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail;

use App\Email;
use App\Contact;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $emails = Email::all();
        $contacts = Contact::where('replied', false)->get();
        return view('admin.index', compact('emails', 'contacts'));
    }

    public function respond(Request $request, $id)
    {
        $contact = Contact::find($id);

        return view('admin.respond', compact('contact'));
    }

    public function send(Request $request, $id)
    {
        $contact = Contact::find($id);
        $body = nl2br($request->body);
        $re = $contact->message;
        Mail::send('email.respond', compact('body', 're'), function ($m) use ($contact) {
            $m->from(getenv('MAIL_FROM_ADDRESS'), getenv('MAIL_FROM_NAME'));
            $m->to($contact->email);
            $m->subject('Re: Your contact form submission on InvoiceOwl');
        });

        $contact->update(['replied' => true]);

        return back();
    }

    public function debugEmail(Request $request, $id)
    {
        $contact = Contact::find($id);
        $body = nl2br($request->body);
        $re = $contact->message;
        return view('email.respond', compact('body', 're'));
    }
}
