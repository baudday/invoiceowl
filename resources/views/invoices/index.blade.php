@extends('layouts.default')

@section('content')
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
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach($invoices as $invoice)
    <tr>
      <td class="vcenter"><a href="{{ route('dashboard.clients.show', $invoice->client->id) }}">{{ $invoice->client->name }}</a></td>
      <td class="vcenter">{{ $invoice->description }}</td>
      <td class="vcenter">{{ date('F d, Y', strtotime($invoice->updated_at)) }}</td>
      <td class="vcenter">{{ date('F d, Y', strtotime($invoice->due_date)) }}</td>
      <td class="vcenter">{{ $invoice->total }}</td>
      <td class="vcenter">
        <form method="post" action="{{ route('dashboard.clients.invoices.update', [$invoice->client->id, $invoice->id]) }}">
          {!! method_field('put') !!}
          {!! csrf_field() !!}
          <input type="hidden" name="paid" value="1">
          <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to mark this invoice as paid? This cannot be undone.');">
            <span class="glyphicon glyphicon-usd"></span>
            Paid
          </button>
        </form>
      </td>
      <td class="vcenter">
        <a class="btn btn-info view-btn" href="#" data-invoice="{{ $invoice->id }}" data-toggle="modal" data-target="preview_modal">
          <span class="glyphicon glyphicon-eye-open"></span>
          View
        </a>
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
