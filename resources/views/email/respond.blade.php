@extends('layouts.email')

@section('top')
<small>This is a reponse to an enquiry you submitted at
<a href="http://invoiceowl.com">InvoiceOwl</a>. You can reply
directly to this email if you'd like.</small>
@stop

@section('content')
<p>{!! $body !!}</p>
<blockquote>{!! $re !!}</blockquote>
@stop
