<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Flynsarmy\DbBladeCompiler\Facades\DbView;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Client;
use App\Invoice;
use App\Template;
use App\LineItem;
use App\TaxItem;

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
        $invoice = $this->userInvoices()->firstOrCreate([
          'owl_id' => $request->input('owl_id'),
          'user_id' => \Auth::user()->id,
          'client_id' => $client_id
        ]);

        // Delete all line items and tax items first
        LineItem::where('invoice_id', $invoice->id)->delete();
        TaxItem::where('invoice_id', $invoice->id)->delete();

        $quantities = $request->input('quantities');
        $prices = $request->input('prices');
        foreach (array_filter($request->input('items')) as $key=>$item) {
          $lineItem = LineItem::create([
            'description' => $item,
            'invoice_id' => $invoice->id,
            'quantity' => $quantities[$key],
            'unit_price' => $prices[$key]
          ]);
        }

        $invoice->update();

        $percentages = $request->input('percentages');
        foreach (array_filter($request->input('taxes')) as $key=>$item) {
          $taxItem = TaxItem::create([
            'description' => $item,
            'invoice_id' => $invoice->id,
            'percentage' => $percentages[$key],
          ]);
        }

        $data = [
          'description' => $request->input('description'),
          'due_date' => date('Y-m-d', strtotime($request->input('due_date'))),
          'template_id' => $template_id,
          'custom_id' => $request->input('custom_id')
        ];

        $invoice->update($data);

        $client = $invoice->client()->first();
        $total = $invoice->total;
        $lineItems = $invoice->lineItems()->get();
        $template = $invoice->template()->first();

        return [
          'body' => DbView::make($template)
                    ->field('body')
                    ->with(compact('client', 'invoice', 'total', 'lineItems'))
                    ->render(),
          'invoice_id' => $invoice->id
        ];
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
