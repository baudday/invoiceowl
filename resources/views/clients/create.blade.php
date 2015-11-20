@extends('layouts.default')

@section('content')
<div class='row'>
  <div class='col-lg-8 col-md-8 col-sm-12 col-xs-12 col-lg-offset-2 col-md-offset-2'>

    <h1>Create a new Client</h1>
    <hr>

    @include('layouts.partials.errors')

    <form method="post" action="{{ route('dashboard.clients.store') }}">

      {!! csrf_field() !!}

      <div class="row">
        <div class="col-xs-12">
          <div class='form-group'>
            <label for='name'>Name</label>
            <input tabindex="1" name='name' type='text' class='form-control input-lg' placeholder='Joe Namath or Acme Corp' data-toggle="tooltip" data-placement="top" title="Who the invoices will be made out to. This could be an individual or company." required>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <div class='form-group'>
            <label for='email'>Email</label>
            <input tabindex="1" name='email' type='email' class='form-control input-lg' placeholder='ex@mp.le' required>
          </div>
        </div>
      </div>

      @include('layouts.partials.address_fields')

      <div class="row">
        <div class="col-xs-12">
          <div class='form-group'>
              <button tabindex="1" type='submit' class='btn btn-lg btn-default'>
                <span class="glyphicon glyphicon-floppy-save"></span> Save
              </button>
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
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
@stop
