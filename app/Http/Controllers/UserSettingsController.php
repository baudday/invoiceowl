<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;

class UserSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $settings = $this->user()->select(['name', 'email', 'phone_number', 'logo'])->first();
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
          'name' => 'required|string',
          'email' => 'required|email',
          'phone_number' => 'numeric|digits:10'
        ]);
        $this->user()->update($request->only(['name', 'email', 'phone_number', 'logo']));
        $request->session()->flash('success', 'Your settings have been saved.');

        return redirect()->route('dashboard.settings.index');
    }
}
