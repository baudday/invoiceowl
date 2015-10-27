@if(!$invoice->paid)
<form method="post" action="{{ route('dashboard.clients.invoices.update', [$invoice->client->id, $invoice->id]) }}">
  {!! method_field('put') !!}
  {!! csrf_field() !!}
  <input type="hidden" name="paid" value="1">
  <div class="btn-group">
    <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to mark this invoice as paid? This cannot be undone.');">
      <span class="glyphicon glyphicon-usd"></span> Paid
    </button>
    <a class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><span class="caret"></span></a>
    <ul class="dropdown-menu">
      <li>
        <a class="view-btn" href="#" data-invoice="{{ $invoice->id }}" data-toggle="modal" data-target="preview_modal">
          <span class="glyphicon glyphicon-eye-open"></span> View
        </a>
      </li>
      <li>
        <a href="{{ route('dashboard.invoices.show', $invoice->id) }}" target="_blank">
          <span class="glyphicon glyphicon-download"></span> Download
        </a>
      </li>
    </ul>
  </div>
</form>
@else
<div class="btn-group">
  <a class="btn btn-info view-btn" href="#" data-invoice="{{ $invoice->id }}" data-toggle="modal" data-target="preview_modal">
    <span class="glyphicon glyphicon-eye-open"></span> View
  </a>
  <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><span class="caret"></span></a>
  <ul class="dropdown-menu">
    <li>
      <a href="{{ route('dashboard.invoices.show', $invoice->id) }}" target="_blank">
        <span class="glyphicon glyphicon-download"></span> Download
      </a>
    </li>
  </ul>
</div>
@endif
