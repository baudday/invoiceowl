<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Template;

class TemplatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $templates = Template::where('user_id', \Auth::user()->id)->get();
        return view('templates/index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('templates/create');
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
          'body' => 'required',
          'thumbnail' => 'required'
        ]);

        Template::create([
          'thumbnail' => $request->input('thumbnail'),
          'body' => $request->input('body'),
          'user_id' => \Auth::user()->id
        ]);

        return redirect()->route('dashboard.templates.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $template = Template::findOrFail($id);
        return view('templates/edit', compact('template'));
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
        $this->validate($request, ['body' => 'required', 'thumbnail' => 'required']);
        $template = Template::findOrFail($id);
        $template->update($request->only('body', 'thumbnail'));
        return redirect()->route('dashboard.templates.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Template::find($id)->delete();
        return redirect()->route('dashboard.templates.index');
    }
}
