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

        $email = Email::create($request->all());

        $mcUrl = getenv('MAILCHIMP_URL');
        $mcData = [
            'MERGE0' => $email->email,
            'u'      => getenv('MAILCHIMP_u'),
            'id'     => getenv('MAILCHIMP_id'),
        ];

        $request->session()->flash('success', "Thanks! Please check your inbox for a confirmation email.");

        //url-ify the data for the POST
        $fields_string = '';
        foreach($mcData as $key=>$value) {
            $fields_string .= $key.'='.$value.'&';
        }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $mcUrl);
        curl_setopt($ch,CURLOPT_POST, count($mcData));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION, true);

        //execute post
        $result = curl_exec($ch);

        //close connection
        curl_close($ch);
    }

    public function thanks(Request $request)
    {
        return view('home');
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
