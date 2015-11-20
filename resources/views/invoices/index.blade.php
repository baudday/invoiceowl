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
      <td class="vcenter">{{ \Auth::user()->currency }}{{ $invoice->total }}</td>
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

@if(session('survey'))
<div class="modal fade" id="survey">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Thanks for using InvoiceOwl!</h4>
      </div>
      <div class="modal-body">
        <h3>{{ \Auth::user()->name }},</h3>
        <p>Thank you for using InvoiceOwl! We would really appreciate it if you
          would take a quick four question survey to let us know what you think.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">No thanks</button>
        <a id="survey_link" target="_blank" href="//invoiceowl.typeform.com/to/VcwgOL" class="btn btn-primary">Sure, I'll help!</a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endif
@stop

@section('body-scripts')
<script type="text/javascript">
  $(function() {
      @if(session('survey'))
      $('#survey').modal('show');
      $('#survey_link').on('click', function() {
        $('#survey').modal('hide');
      });
      @endif
  });
</script>
@stop
