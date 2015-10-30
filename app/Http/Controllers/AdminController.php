<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail;

use App\Email;
use App\Contact;
use App\User;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $emails = Email::where('key', null)->get();
        $users = User::with('invoices', 'clients')->get();
        $unregistered = Email::whereRaw('email not in(select email from users)')->whereNotNull('key')->get();
        $contacts = Contact::where('replied', false)->get();
        return view('admin.index', compact('emails', 'contacts', 'users', 'unregistered'));
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

    public function invite($id)
    {
      $email = Email::findOrFail($id);
      $email->key = $this->generateRandomString();
      $email->save();

      Mail::send('email.invite', compact('email'), function ($m) use ($email) {
          $m->from(getenv('MAIL_FROM_ADDRESS'), getenv('MAIL_FROM_NAME'));
          $m->to($email->email);
          $m->subject("You've been invited to try InvoiceOwl!");
      });

      return redirect()->back();
    }

    public function debugEmail(Request $request, $id)
    {
        $contact = Contact::find($id);
        $body = nl2br($request->body);
        $re = $contact->message;
        return view('email.respond', compact('body', 're'));
    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
