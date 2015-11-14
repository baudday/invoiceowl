@extends('layouts.default')

@section('content')
<h1>Edit Client - {{ $client->name }}</h1>

<div class='row'>
  <div class='col-lg-8 col-md-8 col-sm-12 col-xs-12 col-lg-offset-2 col-md-offset-2'>

    @if(session('success'))
    <div class="alert alert-success">
      <strong>Yay!</strong>
      {{ session('success') }}
    </div>
    @endif

    @include('layouts.partials.errors')

    <form method="post" action="{{ route('dashboard.clients.update', $client->id) }}">

      {!! method_field('PUT') !!}
      {!! csrf_field() !!}

      <div class='form-group'>
        <label for='name'>Name</label>
        <input tabindex="1" name='name' type='text' class='form-control input-lg' value='{{ $client->name }}' required>
      </div>

      <div class='form-group'>
        <label for='email'>Email</label>
        <input tabindex="1" name='email' type='email' class='form-control input-lg' value='{{ $client->email }}' required>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <label>Address (Optional)</label>
          <div class="form-group">
            <label for="line_one">Line 1</label>
            <input tabindex="1" type="text" name="line_one" class="form-control input-lg" id="line_one" placeholder="123 Fake St." value="{{ $client->address->line_one }}">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="form-group">
            <label for="line_two">Line 2</label>
            <input tabindex="1" type="text" name="line_two" class="form-control input-lg" id="line_two" placeholder="Apt. 2F" value="{{ $client->address->line_two }}">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-4">
          <div class="form-group">
            <label for="city">City</label>
            <input tabindex="1" type="text" name="city" class="form-control input-lg" id="city" placeholder="Tulsa" value="{{ $client->address->city }}">
          </div>
        </div>
        <div class="col-xs-4">
          <div class="form-group">
            <label for="state">State/Province</label>
            <input tabindex="1" type="text" name="state" class="form-control input-lg" id="state" placeholder="OK" value="{{ $client->address->state }}">
          </div>
        </div>
        <div class="col-xs-4">
          <div class="form-group">
            <label for="zip">Zip</label>
            <input tabindex="1" type="text" name="zip" class="form-control input-lg" id="zip" placeholder="90210" value="{{ $client->address->zip }}">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="form-group">
            <label for="country">Country</label>
            <input tabindex="1" type="text" name="country" class="form-control input-lg" id="country" placeholder="United States" value="{{ $client->address->country }}">
          </div>
        </div>
      </div>

      <div class='form-group'>
          <button tabindex="1" type='submit' class='btn btn-lg btn-default'>Update</button>
      </div>

    </form>

  </div>
</div>
@stop
