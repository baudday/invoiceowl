@extends('layouts.default')

@section('content')
<h2>Welcome {{ \Auth::user()->company_name ?: \Auth::user()->name }}!</h2>
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
            @include('invoices.partials.actions')
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
    <h4 style="text-align:center;">Everything's up to date :)</h4>
    @endif
  </div>
</div>
@include('invoices.partials.preview')
@stop
