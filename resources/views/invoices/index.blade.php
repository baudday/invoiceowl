@extends('layouts.default')

@section('content')
@if(session('download'))
<div class="alert alert-success">
  <strong>Invoice created.</strong>
  <a href="{{ route('dashboard.invoices.show', session('download')) }}" target="_blank">Click here</a>
  to download.
</div>
@endif
<h1>Unpaid Invoices</h1>
<hr>
@if($invoices->count() > 0)
<table class='table table-bordered table-hover'>
  <thead>
    <tr>
      <th>Client</th>
      <th>Description</th>
      <th>Date Sent</th>
      <th>Due Date</th>
      <th>Amount</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach($invoices as $invoice)
    <tr>
      <td class="vcenter"><a href="{{ route('dashboard.clients.show', $invoice->client->id) }}">{{ $invoice->client->name }}</a></td>
      <td class="vcenter">{{ $invoice->description }}</td>
      <td class="vcenter">{{ date('F d, Y', strtotime($invoice->sent_date)) }}</td>
      <td class="vcenter">{{ date('F d, Y', strtotime($invoice->due_date)) }}</td>
      <td class="vcenter">{{ $invoice->total }}</td>
      <td class="vcenter">
          @include('invoices.partials.actions')
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@else
<h2 style="text-align:center;">No one owes you anything! :)</h2>
@endif
@include('invoices.partials.preview')
@stop
