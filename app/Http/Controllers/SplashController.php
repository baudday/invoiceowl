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
        return view('home');
    }

    public function email(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:emails'
        ]);

        Email::create($request->all());

        return back()->with('success', "Thanks! Please check your inbox for a confirmation email.");
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
