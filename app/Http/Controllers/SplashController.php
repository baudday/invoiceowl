<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Email;
use App\Contact;

class SplashController extends Controller
{
    public function home()
    {
        if (\Auth::check()) {
          return redirect()->route('dashboard');
        }
        return view('home');
    }

    public function email(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:emails'
        ]);

        $email = Email::create($request->all());
        \Newsletter::subscribe($email->email);

        return redirect('/')->with('success', "Thanks! We'll send you an invite as soon as one becomes available.");
    }

    public function contact(Request $request)
    {
        $this->validate($request, [
            'contact_email' => 'required|email',
            'message' => 'required'
        ]);

        $data = [
            'email' => $request->get('contact_email'),
            'message' => nl2br(strip_tags($request->get('message')))
        ];

        Contact::create($data);

        return back()->with('success', "Thanks! We'll be in touch soon. Don't forget to request early access!");
    }
}
