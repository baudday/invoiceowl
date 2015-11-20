<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Address;

class UserSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Create a new address on the fly for users who didn't submit one at registration
        Address::firstOrCreate(['user_id' => \Auth::user()->id]);
        $settings = User::with('address')->find(\Auth::user()->id);
        return view('user_settings/index', compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
          'name' => 'required|string|max:255',
          'phone_number' => 'numeric|digits:10',
          'company_name' => 'string|max:255',
          'currency' => 'required|string|max:1',
          'line_one' => 'max:255',
          'line_two' => 'max:255',
          'city' => 'max:255',
          'state' => 'max:255',
          'zip' => 'max:255',
          'country' => 'max:255'
        ]);
        $this->user()->update($request->only(['name', 'phone_number', 'logo', 'company_name', 'currency']));
        $this->user()->address()->update($request->only(['line_one', 'line_two', 'city', 'state', 'zip', 'country']));
        $request->session()->flash('success', 'Your settings have been saved.');

        return redirect()->route('dashboard.settings.index');
    }
}
