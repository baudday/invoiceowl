@extends('layouts.default')

@section('content')
<h2>Welcome {{ \Auth::user()->name }}! Here is your account at a glance.</h2>
<hr>
<div class="row">
  <div class="col-sm-12">
    <h3>Past due Invoices</h3>
    <hr>
    @if($pastDueInvoices->count() > 0)
    <table class='table table-bordered table-condensed'>
      <thead>
        <tr>
          <th>Client</th>
          <th>Description</th>
          <th>Due Date</th>
          <th>Amount</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($pastDueInvoices as $invoice)
        <tr>
          <td class="vcenter"><a href="{{ route('dashboard.clients.show', $invoice->client->id) }}">{{ $invoice->client->name }}</a></td>
          <td class="vcenter">{{ $invoice->description }}</td>
          <td class="vcenter">{{ date('F d, Y', strtotime($invoice->due_date)) }}</td>
          <td class="vcenter">{{ $invoice->total }}</td>
          <td class="vcenter">
            <form method="post" action="{{ route('dashboard.clients.invoices.update', [$invoice->client->id, $invoice->id]) }}">
              <a class="btn btn-info view-btn" href="#" data-invoice="{{ $invoice->id }}" data-toggle="modal" data-target="preview_modal">
                <span class="glyphicon glyphicon-eye-open"></span>
                View
              </a>
              {!! method_field('put') !!}
              {!! csrf_field() !!}
              <input type="hidden" name="paid" value="1">
              <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to mark this invoice as paid? This cannot be undone.');">
                <span class="glyphicon glyphicon-usd"></span>
                Paid
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
    <h4>Everything's up to date :)</h4>
    @endif
  </div>
</div>
@include('invoices.partials.preview')
@stop
