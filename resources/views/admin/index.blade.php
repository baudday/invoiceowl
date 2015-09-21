@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <h1>Early Access Requests <span class="badge">{{ $emails->count() }}</span></h1>
        <hr>
        <table class="table table-bordered">
            <tbody>
            @foreach ($emails as $email)
                <tr><td>{{ $email->email }}</td></tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <h1>Contacts w/o Replies <span class="badge">{{ $contacts->count() }}</span></h1>
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Message</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contacts as $contact)
                <tr>
                    <td>
                        {{ $contact->email }}
                    </td>
                    <td>{!! $contact->message !!}</td>
                    <td><a href="{{ route('contact.respond', ['id' => $contact->id]) }}" type="button" class="btn btn-default">Respond</a></td>
                <tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop
