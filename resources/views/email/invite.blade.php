@extends('layouts.email')

@section('top')
<small>Woohoo! You've been invited to try <a href="http://invoiceowl.com">InvoiceOwl</a>!</small>
@stop

@section('content')
<h1>Congratulations!</h1>
<h3>You've been invited to try InvoiceOwl.
  <a href="{{ url(route('register', ['email' => $email->email, 'key' => $email->key])) }}">Click here</a>
  to register or go to the following URL:
</h3>

<h3>{{ url(route('register', ['email' => $email->email, 'key' => $email->key])) }}</h3>

<br />
<p>
  Thanks,
  <br />
  The InvoiceOwl Team
</p>
@stop
