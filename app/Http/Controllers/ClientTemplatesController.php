<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Flynsarmy\DbBladeCompiler\Facades\DbView;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Client;
use App\Template;

class ClientTemplatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Request $request, $client_id, $template_id)
    {
        $client = Client::findOrFail($client_id);
        $number = $request->input('number');
        $description = $request->input('description');
        $due_date = $request->input('due_date');
        $user = \Auth::user();
        $template = Template::findOrFail($template_id);
        return DbView::make($template)->field('body')->with(compact('client', 'number', 'description', 'due_date', 'user'))->render();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
