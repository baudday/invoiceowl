@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <h1>Early Access Requests <span class="badge">{{ $emails->count() }}</span></h1>
        <hr>
        <table class="table table-bordered table-hover">
            <tbody>
            @foreach ($emails as $email)
                <tr>
                  <td class="vcenter">{{ $email->email }}</td>
                  <td class="vcenter">
                    @if(!$email->key)
                    <form method="post" action="{{ route('email.invite', $email->id) }}">
                      {!! method_field('PUT') !!}
                      {!! csrf_field() !!}
                      <button type="submit" class="btn btn-sm btn-success">
                        <span class="glyphicon glyphicon-envelope"></span> Send Beta Invite
                      </button>
                    </form>
                    @endif
                </tr>
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
