<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Client;
use App\Invoice;
use App\Template;
use App\Lib\PdfGenerator;

class ClientInvoicesController extends Controller
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
    public function create($client_id)
    {
        $client = $this->userClients()->findOrFail($client_id);
        $invoice_number = $this->userClientInvoices($client_id)->latest()->published()->first() ? $this->userClientInvoices($client_id)->latest()->published()->first()->number+1 : 1;
        $templates = Template::available()->get();
        return view('clients.invoices.create', compact('client', 'invoice_number', 'templates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store($client_id, Request $request)
    {
        $this->validate($request, [
          'number' => 'required|numeric',
          'due_date' => 'required|date|after:yesterday',
          'description' => 'required',
          'template' => 'required'
        ]);

        $due_date = date('Y-m-d', strtotime($request->input('due_date')));

        $invoice = $this->userClientInvoices($client_id)->where($request->only('number', 'description') + ['due_date' => $due_date])->first();
        $template = Template::find($invoice->template_id);
        $pdfGenerator = new PdfGenerator($template);
        $pdfGenerator->makeHtml($invoice->client, $invoice, $invoice->total);
        $pdfGenerator->generate();
        $invoice->update([
          'published' => true,
          'pdf_path' => $pdfGenerator->pdfPath(),
          'sent_date' => date('Y-m-d')
        ]);

        if ($request->input('submit_action') == 'download') {
          // Flash download to invoices index so user doesn't stay on create page
          $request->session()->flash('download', $invoice->id);
        }
        else {
          $user = \Auth::user();
          $client = $invoice->client;

          \Mail::send('email.invoice', compact('user', 'client'), function ($m) use ($client, $invoice) {
            $display = 'invoice_' . date('m-d-Y', strtotime($invoice->sent_date)) . '.pdf';
            $m->attach($invoice->pdf_path, ['as' => $display]);
            $m->from(\Auth::user()->email, \Auth::user()->name);
            $m->to($client->email);
            $m->subject(\Auth::user()->name . " has sent you an invoice using InvoiceOwl");
          });
        }

        return redirect()->route('dashboard.invoices.index');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $client_id, $invoice_id)
    {
        $invoice = $this->userClientInvoices($client_id)->findOrFail($invoice_id);
        $invoice->update(array_filter($request->only('number', 'description', 'due_date', 'paid', 'published')));
        return redirect()->back();
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
