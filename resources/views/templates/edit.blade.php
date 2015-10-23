@extends('layouts.default')

@section('content')
<h1>Edit Template</h1>

<div class='row'>
  <div class='col-lg-8 col-md-8 col-sm-12 col-xs-12 col-lg-offset-2 col-md-offset-2'>

    @include('layouts.partials.errors')

    <form class='form-horizontal' method="post" action="{{ route('dashboard.templates.update', $template->id) }}">

      {!! method_field('PUT') !!}
      {!! csrf_field() !!}

      <div class='form-group'>
        <label for='email'>Body</label>
        <textarea name='body' class='form-control input-lg' rows="20" required>{{ $template->body }}</textarea>
      </div>

      <div class='form-group'>
          <button type='submit' class='btn btn-lg btn-default'><span class="glyphicon glyphicon-floppy-save"></span> Save</button>
      </div>

    </form>

  </div>
</div>
@stop
