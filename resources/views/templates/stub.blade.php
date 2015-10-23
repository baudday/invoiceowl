@extends('layouts.template')

@section('body')
  <div class="row">
    <div class="col-xs-12">
      <img src="{{ \Auth::user()->logo }}">
      <h2>{{ \Auth::user()->name }}</h2>
      <p>
        {{ \Auth::user()->email }}
        <br />
        {{ \Auth::user()->phone_number }}
      </p>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <h1>{{ $invoice->description }}</h1>
      <h4>Submitted on {{ date('F d, Y', strtotime($invoice->created_at)) }}</h4>
      <h4>Due on {{ date('F d, Y', strtotime($invoice->due_date)) }}</h4>
    </div>
  </div>

  <div class="row">

    <div class="col-xs-4">
      <h3>Invoice for</h3>
      <p>
        {{ $client->name }}<br />
        {{ $client->email }}
      </p>
    </div>

    <div class="col-xs-4">
      <h3>Payable to</h3>
      <p>{{ \Auth::user()->name }}</p>
    </div>

    <div class="col-xs-4">
      <h3>Invoice #</h3>
      <p>{{ $invoice->number }}</p>
    </div>

  </div>

  <div class="row">

    <div class="col-xs-12">
      <table class='table table-bordered'>
        <thead>
          <tr>
            <th>Description</th>
            <th>Qty</th>
            <th>Unit Price</th>
            <th>Total Price</th>
          </tr>
        </thead>
        <tbody>
          @foreach($invoice->lineItems as $item)
          <tr>
            <td>{{ $item->description }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->unit_price }}</td>
            <td>{{ number_format($item->quantity * $item->unit_price, 2) }}</td>
          </tr>
          @endforeach

          <tr>
            <td></td>
            <td></td>
            <td><strong>Total:</strong></td>
            <td>{{ number_format($total, 2) }}</td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
@stop
