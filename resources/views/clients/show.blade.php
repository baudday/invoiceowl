@extends('layouts.default')

@section('content')
<h1>
  <a href="{{ route('dashboard.clients.invoices.create', $client->id) }}" class="btn btn-lg btn-success">
    <span class="glyphicon glyphicon-usd"></span> Invoice</span>
  </a>
  {{ $client->name }} <small>{{ $client->email }}</small>
</h1>
<hr>

<h2>Past Invoices</h2>
<table class='table table-bordered '>
  <thead>
    <tr>
      <th>#</th>
      <th>Description</th>
      <th>Date Sent</th>
      <th>Due Date</th>
      <th>Amount</th>
      <th>Paid</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach($client->invoices as $invoice)
    <tr class="{{ $invoice->paid ? 'success' : 'danger' }}">
      <td class="vcenter">{{ $invoice->number }}</td>
      <td class="vcenter">{{ $invoice->description }}</td>
      <td class="vcenter">{{ date('F d, Y', strtotime($invoice->sent_date)) }}</td>
      <td class="vcenter">{{ date('F d, Y', strtotime($invoice->due_date)) }}</td>
      <td class="vcenter">{{ $invoice->total }}</td>
      <td class="vcenter">
        @if(!$invoice->paid)
        <form method="post" action="{{ route('dashboard.clients.invoices.update', [$invoice->client->id, $invoice->id]) }}">
          {!! method_field('put') !!}
          {!! csrf_field() !!}
          <input type="hidden" name="paid" value="1">
          <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to mark this invoice as paid? This cannot be undone.');">
            <span class="glyphicon glyphicon-usd"></span>
            Paid
          </button>
        </form>
        @else
        <span class='glyphicon glyphicon-ok'></span></td>
        @endif
      <td class="vcenter">
          <a class="btn btn-info view-btn" href="#" data-invoice="{{ $invoice->id }}" data-toggle="modal" data-target="preview_modal">
            <span class="glyphicon glyphicon-eye-open"></span>
            View
          </a>
      </td>
    @endforeach
  </tbody>
</table>
@include('invoices.partials.preview')
@stop
