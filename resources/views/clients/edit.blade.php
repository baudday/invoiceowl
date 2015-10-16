@extends('layouts.default')

@section('content')
<h1>Edit Client - {{ $client->name }}</h1>

<div class='row'>
  <div class='col-lg-8 col-md-8 col-sm-12 col-xs-12 col-lg-offset-2 col-md-offset-2'>

    @include('layouts.partials.errors')

    <form class='form-horizontal' method="post" action="{{ route('dashboard.clients.update', $client->id) }}">

      {!! method_field('PUT') !!}
      {!! csrf_field() !!}

      <div class='form-group'>
        <label for='name'>Name</label>
        <input name='name' type='text' class='form-control input-lg' value='{{ $client->name }}' required>
      </div>

      <div class='form-group'>
        <label for='email'>Email</label>
        <input name='email' type='email' class='form-control input-lg' value='{{ $client->email }}' required>
      </div>

      <div class='form-group'>
          <button type='submit' class='btn btn-lg btn-default'>Update</button>
      </div>

    </form>

  </div>
</div>
@stop
