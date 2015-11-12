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
      <th>ID</th>
      <th>Description</th>
      <th>Date Sent</th>
      <th>Due Date</th>
      <th>Amount</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach($client->invoices as $invoice)
    <tr class="{{ $invoice->paid ? 'success' : 'danger' }}">
      <td class="vcenter">{{ $invoice->owl_id }}</td>
      <td class="vcenter">{{ $invoice->description }}</td>
      <td class="vcenter">{{ date('F d, Y', strtotime($invoice->sent_date)) }}</td>
      <td class="vcenter">{{ date('F d, Y', strtotime($invoice->due_date)) }}</td>
      <td class="vcenter">{{ \Auth::user()->currency }}{{ $invoice->total }}</td>
      <td class="vcenter">
        @include('invoices.partials.actions')
      </td>
    @endforeach
  </tbody>
</table>
@include('invoices.partials.preview')
@stop
