<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Client;

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
          'name' => 'required'
        ]);

        $client = $this->userClients()->create($request->only(['email', 'name']));

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
        $client = $this->userClients()->findOrFail($id);
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
          'name' => 'required'
        ]);
        $this->userClients()->findOrFail($id)->update($request->only(['email', 'name']));

        return redirect()->route('dashboard.clients.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->userClients()->destroy($id);
        return redirect()->route('dashboard.clients.index');
    }
}
