@extends('layouts.default')

@section('content')
<h1>Invoice {{ $client->name }}</h1>

<div class='row'>
  <div class='col-lg-8 col-md-8 col-sm-12 col-xs-12 col-lg-offset-2 col-md-offset-2'>

    @include('layouts.partials.errors')

    <form class='form-horizontal' method="post" action="{{ route('dashboard.clients.invoices.store', $client->id) }}">

      {!! csrf_field() !!}

      <div class='row'>
        <div class='form-group'>
          <div class='col-xs-12'>
            <h3>Basic Information</h3>
            <hr>
          </div>
        </div>
      </div>

      <div class='row'>
        <div class='form-group'>
          <div class='col-sm-4'>
            <label for='number'>#</label>
            <input id="number" name='number' type='text' class='form-control input-lg' placeholder='1' value="{{ $invoice_number }}" readonly="readonly" required>
          </div>

          <div class='col-sm-8'>
            <label for='due_date'>Due Date</label>
            <input id="due_date" type='date' name='due_date' class='form-control input-lg' value="{{ old('due_date') }}" required>
          </div>
        </div>
      </div>

      <div class='row'>
        <div class='form-group'>
          <div class='col-sm-12'>
            <label for='email'>Description</label>
            <textarea id="description" name='description' class='form-control input-lg' placeholder='What is this for?' required>{{ old('description') }}</textarea>
          </div>
        </div>
      </div>

      <div class='row'>
        <div class='form-group'>
          <div class='col-xs-12'>
            <h3>Line Items</h3>
            <hr>
          </div>
        </div>
      </div>

      <div class='row'>
        <div class='form-group'>
          <div class='col-sm-8'>
            <label>Item Description</label>
            <input name='item[]' type='text' class='form-control input-lg' required>
          </div>

          <div class='col-sm-2'>
            <label>Qty</label>
            <input type='number' name='quantity[]' class='form-control input-lg' required>
          </div>

          <div class='col-sm-2'>
            <label>Unit Price</label>
            <input type="number" name='price[]' class='form-control input-lg' min="0.00" step="0.50" max="9999.99" required>
          </div>
        </div>
      </div>

      @for($i = 0; $i < 3; $i++)
      <div class='row'>
        <div class='form-group'>
          <div class='col-sm-8'>
            <input name='item[]' type='text' class='form-control input-lg'>
          </div>

          <div class='col-sm-2'>
            <input type='number' name='quantity[]' class='form-control input-lg'>
          </div>

          <div class='col-sm-2'>
            <input type="number" name='price[]' class='form-control input-lg' min="0.00" step="0.50" max="9999.99">
          </div>
        </div>
      </div>
      @endfor

      <div class='row'>
        <div class='form-group'>
          <div class='col-xs-12'>
            <h3>Choose a Template</h3>
            <hr>
          </div>
        </div>
      </div>

      <div class="row templates">
        <div class="form-group">
          <div class="col-xs-12">
            @foreach($templates as $template)
            <a href="#" class="template" data-template="{{ $template->id }}"><img src="{{ $template->thumbnail }}" alt="" /></a>
            @endforeach
          </div>
        </div>
      </div>

      <div class="row">
        <div class="form-group">
          <div class="col-xs-12">
            <h3>Preview</h3>
            <hr>
            <div class="preview"><h2 class="muted"><small>Select a template from above to preview your invoice.</small></h2></div>
            <hr>
          </div>
        </div>
      </div>

      <div class='row'>
        <div class='form-group'>
          <div class='col-xs-12'>
              <button type='submit' class='btn btn-lg btn-default'><span class='glyphicon glyphicon-send'></span> Send</button>
          </div>
        </div>
      </div>

    </form>

  </div>
</div>
@stop

@section('body-scripts')
<script type="text/javascript">
  $(function() {
    $('.template').on('click', function() {
      var href = '/api/v1/clients/{{ $client->id }}/templates/' + $(this).data('template');
      $.ajax({
        url: href,
        data: {
          'number': $('#number').val(),
          'due_date': $('#due_date').val(),
          'description': $('#description').val()
        }
      }).done(function(body) {
        $('.preview').html(body);
      });

      return false;
    });
  });
</script>
@stop
