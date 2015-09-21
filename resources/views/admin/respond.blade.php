@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-xs-12">
        @if ($contact->replied)
        <div class="alert alert-success">You have responded to this request. Continue the conversation via email.</div>
        @endif
        <h1>Respond to {{ $contact->email }}</h1>
        <p>{!! $contact->message !!}</p>
        @if (!$contact->replied)
        <form action="" method="POST" role="form">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="">Reponse</label>
                <textarea name="body" id="body" class="form-control input-lg" rows="10" required="required"></textarea>
            </div>
            <button type="submit" class="btn btn-default btn-lg">Send</button>
        </form>
        @endif
    </div>
</div>
@stop
