@extends('layouts.default')

@section('content')
<h1>User Settings</h1>

<div class='row '>

  <div class='col-lg-8 col-md-8 col-sm-12 col-xs-12 col-lg-offset-2 col-md-offset-2'>

    @include('layouts.partials.errors')

    @if(session('success'))
    <div class="alert alert-success">
      <strong>Yay!</strong>
      {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('dashboard.settings.update', \Auth::user()->id) }}" method="post">

      {!! method_field('PUT') !!}
      {!! csrf_field() !!}

      <div class='form-group'>
        <label for='name'>Name</label>
        <input type='text' name='name' class='form-control input-lg' value='{{ $settings->name }}' required>
      </div>

      <div class='form-group'>
        <label for='email'>Email</label>
        <input type='email' name='email' class='form-control input-lg' value='{{ $settings->email }}' required>
      </div>

      <div class='form-group'>
        <label for='name'>Phone Number</label>
        <input type='text' name='phone_number' class='form-control input-lg' value='{{ $settings->phone_number }}'>
      </div>

      <div class='form-group'>
          <button type='submit' class='btn btn-lg btn-default'>Update</button>
      </div>

    </form>

  </div>

</div>
@stop
