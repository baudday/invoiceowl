@extends('layouts.template')

@section('styles')
.body {
  font-family: 'courier new', monospace;
}

.cell {
  width: 100%;
  padding: 8px;
  padding-left: 5px;
  border-bottom: 1px dotted #8f8f8f;
}
@stop

@section('body')
  <div class="row" style="margin-bottom: 50px;">
    <div class="col-xs-12">
      <div class="pull-left" style="margin-top: 20px;">
        <img src="{{ \Auth::user()->logo }}">
        <h2>{{ \Auth::user()->name }}</h2>
        <p>
          {{ \Auth::user()->email }}
          <br />
          {{ \Auth::user()->phone_number }}
        </p>
      </div>
      <div class="pull-right">
        <h1>Invoice</h1>
        <h4>Submitted on {{ date('F d, Y', strtotime($invoice->created_at)) }}</h4>
        <h4>Due on {{ date('F d, Y', strtotime($invoice->due_date)) }}</h4>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <h1>{{ $invoice->description }}</h1>
    </div>
  </div>

  <div class="row" style="margin-bottom: 50px;">

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

      <div class="row" style="">
        <div class="col-xs-3">
          <div style="padding: 5px;">
            <strong>Description</strong>
          </div>
        </div>
        <div class="col-xs-3">
          <div style="padding: 5px;">
            <strong>Qty</strong>
          </div>
        </div>
        <div class="col-xs-3">
          <div style="padding: 5px;">
            <strong>Unit Price</strong>
          </div>
        </div>
        <div class="col-xs-3">
          <div style="padding: 5px;">
            <strong>Total Price</strong>
          </div>
        </div>
      </div>

      @foreach($invoice->lineItems as $item)
      <div class="row" style="">
        <div class="col-xs-3">
          <div class="cell">
            {{ $item->description }}
          </div>
        </div>
        <div class="col-xs-3">
          <div class="cell">
            {{ $item->quantity }}
          </div>
        </div>
        <div class="col-xs-3">
          <div class="cell">
            {{ $item->unit_price }}
          </div>
        </div>
        <div class="col-xs-3">
          <div class="cell">
            {{ number_format($item->quantity * $item->unit_price, 2) }}
          </div>
        </div>
      </div>
      @endforeach

      <div class="row" style="">
        <div class="col-xs-3 col-xs-offset-6">
          <div class="cell" style="text-align:right;">
            <strong>Total:</strong>
          </div>
        </div>
        <div class="col-xs-3">
          <div class="cell">
            {{ $total }}
          </div>
        </div>
      </div>

    </div>

  </div>
@stop
