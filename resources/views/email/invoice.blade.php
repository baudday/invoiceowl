@extends('layouts.email')

@section('top')
<small>You have received an invoice from <a href="http://invoiceowl.com">InvoiceOwl</a></small>
@stop

@section('content')
<h1>Hi {{ $client->name }},</h1>
<h3>{{ $user->name }} has sent you an invoice using <a href="http://invoiceowl.com">InvoiceOwl</a>.</h3>

@if (isset($email_message))
<h3>They say...</h3>
<p>
<blockquote>{!! $email_message !!}</blockquote>
</p>
@endif

<h3>We have attached your invoice to this email, as a PDF. Replies will be sent
  to {{ $user->name }}
  &lt;<a href="mailto:{{$user->email}}">{{ $user->email }}</a>&gt;.</h3>
@stop
