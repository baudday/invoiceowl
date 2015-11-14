<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Client;
use App\Address;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $clients = $this->userClients()->orderBy('name', 'asc')->get();
        return view('clients/index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('clients/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
          'email' => 'required|email',
          'name' => 'required',
          'line_one' => 'max:255',
          'line_two' => 'max:255',
          'city' => 'max:255',
          'state' => 'max:255',
          'zip' => 'max:255',
          'country' => 'max:255'
        ]);

        $address = Address::create($request->only(['line_one', 'line_two', 'city', 'state', 'zip', 'country']));
        $client = $this->userClients()->create($request->only(['email', 'name']));
        $client->address()->save($address);

        return redirect()->route('dashboard.clients.show', $client->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $client = $this->userClients()->with([
          'invoices' => function($q) {
            // Show newest invoices first
            $q->published()->orderBy('sent_date', 'desc');
          }
        ])->findOrFail($id);
        return view('clients/show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        Address::firstOrCreate(['client_id' => $id]);
        $client = $this->userClients()->with('address')->findOrFail($id);
        return view('clients/edit', compact('client'));
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
          'email' => 'required|email',
          'name' => 'required',
          'line_one' => 'max:255',
          'line_two' => 'max:255',
          'city' => 'max:255',
          'state' => 'max:255',
          'zip' => 'max:255',
          'country' => 'max:255'
        ]);
        $client = $this->userClients()->findOrFail($id);
        $client->update($request->only(['email', 'name']));
        $client->address()->update($request->only(['line_one', 'line_two', 'city', 'state', 'zip', 'country']));
        $request->session()->flash('success', "$client->name's settings have been updated!");

        return redirect()->route('dashboard.clients.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->userClients()->delete($id);
        return redirect()->route('dashboard.clients.index');
    }
}
