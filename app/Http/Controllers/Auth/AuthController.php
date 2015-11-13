<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Address;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectPath = '/dashboard';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'currency' => 'required|max:1',
            'email' => 'required|email|max:255|unique:users',
            'phone_number' => 'numeric|digits:10',
            'company_name' => 'max:255',
            'password' => 'required|confirmed|min:6',
            'line_one' => 'max:255',
            'line_two' => 'max:255',
            'city' => 'max:255',
            'state' => 'max:255',
            'zip' => 'max:255',
            'country' => 'max:255'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'company_name' => $data['company_name'],
            'password' => bcrypt($data['password']),
            'logo' => $data['logo'],
            'currency' => $data['currency'],
            'phone_number' => $data['phone_number']
        ]);

        $user->address()->save(Address::create(array_only($data, ['line_one', 'line_two', 'city', 'state', 'zip', 'country'])));

        return $user;
    }
}
