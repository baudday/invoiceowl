@extends('layouts.default')

@section('content')
<div class="row">
  <div class="col-xs-12">
    <h2>Welcome {{ \Auth::user()->company_name ?: \Auth::user()->name }}! <small>Here are some stats for you.</small></h2>
  </div>
</div>

<ul id="tabs" class="nav nav-tabs" role="tablist">
  <li role="presentation" class="active"><a href="#month" aria-controls="month" role="tab" data-toggle="tab">This month</a></li>
  <li role="presentation"><a href="#all_time" aria-controls="all_time" role="tab" data-toggle="tab">All time</a></li>
</ul>

<div class="tab-content">
  <div role="tabpanel" class="tab-pane active" id="month">
    <div class="row">
      <div class="col-xs-12">
        <h3>This month you have...</h3>
        <hr>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4">
        <div class="panel panel-default vcenter">
          <div class="panel-body">
            <h3>Invoices Sent</h3>
            <hr>
            <h1 class="count">{{ $month['sent_count'] }}</h1>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default vcenter">
          <div class="panel-body">
            <h3>Invoices Paid</h3>
            <hr>
            <h1 class="count">{{ $month['paid_count'] }}</h1>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default vcenter alert-success">
          <div class="panel-body">
            <h3>Collected</h3>
            <hr>
            <h1>$<span class="money">{{ number_format($month['collected'], 2) }}</span></h1>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4">
        <div class="panel panel-default vcenter @if($all_time['past_due_count'] > 0) alert-danger @endif">
          <div class="panel-body">
            <h3>Invoices Past Due</h3>
            <hr>
            <h1 class="count">{{ $all_time['past_due_count'] }}</h1>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default vcenter @if($all_time['unpaid_count'] > 0) alert-danger @endif">
          <div class="panel-body">
            <h3>Invoices Unpaid</h3>
            <hr>
            <h1 class="count">{{ $all_time['unpaid_count'] }}</h1>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default vcenter @if($all_time['uncollected'] > 0) alert-danger @endif">
          <div class="panel-body">
            <h3>Uncollected</h3>
            <hr>
            <h1>$<span class="money">{{ number_format($all_time['uncollected'], 2) }}</span></h1>
          </div>
        </div>
      </div>
    </div>
  </div>



  <div role="tabpanel" class="tab-pane" id="all_time">
    <div class="row">
      <div class="col-xs-12">
        <h3 data-toggle="tooltip" data-placement="left" title="Or at least since you joined InvoiceOwl">Since the beginning of time you have...</h3>
        <hr>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4">
        <div class="panel panel-default vcenter">
          <div class="panel-body">
            <h3>Invoices Sent</h3>
            <hr>
            <h1 class="count">{{ $all_time['sent_count'] }}</h1>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default vcenter">
          <div class="panel-body">
            <h3>Invoices Paid</h3>
            <hr>
            <h1 class="count">{{ $all_time['paid_count'] }}</h1>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default vcenter alert-success">
          <div class="panel-body">
            <h3>Collected</h3>
            <hr>
            <h1>$<span class="money">{{ number_format($all_time['collected'], 2) }}</span></h1>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4">
        <div class="panel panel-default vcenter @if($all_time['past_due_count'] > 0) alert-danger @endif">
          <div class="panel-body">
            <h3>Invoices Past Due</h3>
            <hr>
            <h1 class="count">{{ $all_time['past_due_count'] }}</h1>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default vcenter @if($all_time['unpaid_count'] > 0) alert-danger @endif">
          <div class="panel-body">
            <h3>Invoices Unpaid</h3>
            <hr>
            <h1 class="count">{{ $all_time['unpaid_count'] }}</h1>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default vcenter alert-danger">
          <div class="panel-body">
            <h3>Uncollected</h3>
            <hr>
            <h1>$<span class="money">{{ number_format($all_time['uncollected'], 2) }}</span></h1>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@if($pastDueInvoices->count() > 0)
<div class="row">
  <div class="col-sm-12">
    <h3>Past due Invoices</h3>
    <hr>
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
  </div>
</div>
@endif
@include('invoices.partials.preview')
@stop

@section('body-scripts')
<script type="text/javascript">
  $(function() {
    renderCounts();

    $('#tabs a').click(function (e) {
      e.preventDefault()
      $(this).tab('show');
      renderCounts();
    });

    $('[data-toggle="tooltip"]').tooltip()
  });

  function animateNumber(init, $this, step, complete, duration) {
    step = step || function() { $this.text(Math.ceil(this.Counter)) };
    complete = complete || function() { $this.text(init) };
    duration = duration || 250

    jQuery({ Counter: 0 }).animate({ Counter: $this.text().replace(',', '') }, {
      duration: duration,
      easing: 'swing',
      step: step,
      complete: complete
    });
  }

  function renderCounts() {
    $('.count').each(function () {
      var $this = $(this);
      animateNumber($this.text(), $this);
    });

    $('.money').each(function () {
      var $this = $(this);
      animateNumber($this.text(), $this, function () {
        $this.text((Math.ceil(this.Counter * 100) / 100).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
      });
    });
  }
</script>
@stop
