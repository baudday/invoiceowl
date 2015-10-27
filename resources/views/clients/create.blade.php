@extends('layouts.default')

@section('content')
<div class='row'>
  <div class='col-lg-8 col-md-8 col-sm-12 col-xs-12 col-lg-offset-2 col-md-offset-2'>

    @include('layouts.partials.errors')

    <form class='form-horizontal' method="post" action="{{ route('dashboard.clients.store') }}">

      {!! csrf_field() !!}

      <div class='form-group'>
        <label for='name'>Name</label>
        <input name='name' type='text' class='form-control input-lg' placeholder='Joe Namath or Acme Corp' data-toggle="tooltip" data-placement="top" title="Who the invoices will be made out to. This could be an individual or company." required>
      </div>

      <div class='form-group'>
        <label for='email'>Email</label>
        <input name='email' type='email' class='form-control input-lg' placeholder='ex@mp.le' required>
      </div>

      <div class='form-group'>
          <button type='submit' class='btn btn-lg btn-default'>
            <span class="glyphicon glyphicon-floppy-save"></span> Save
          </button>
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
