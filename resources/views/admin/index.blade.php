@extends('layouts.admin')

@section('content')
<div class="row">
  <div class="col-sm-6">
      <h1>Requested Invites</h1>
      <hr>
      <table class="table table-bordered table-hover table-condensed">
          <tbody>
          @foreach ($emails as $email)
              <tr>
                <td class="vcenter">{{ date('m/d/Y', strtotime($email->created_at)) }}</td>
                <td class="vcenter">{{ $email->email }}</td>
                <td class="vcenter">
                  @if(!$email->key)
                  <form method="post" action="{{ route('email.invite', $email->id) }}">
                    {!! method_field('PUT') !!}
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-sm btn-success">
                      <span class="glyphicon glyphicon-envelope"></span> Invite
                    </button>
                  </form>
                  @endif
              </tr>
          @endforeach
          </tbody>
      </table>
  </div>
  <div class="col-sm-6">
    <h1>Unregistered Users</h1>
    <hr>
    <table class='table table-bordered table-hover table-condensed'>
      <thead>
        <tr>
          <th>Email</th>
          <th>Key</th>
        </tr>
      </thead>
      <tbody>
      @foreach($unregistered as $u)
        <tr>
          <td class="vcenter">{{$u->email}}</td>
          <td class="vcenter">{{$u->key}}</td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <h1>Registered Users</h1>
    <hr>
    <table class="table table-bordered table-hover table-condensed">
      <thead>
        <th>Name</th>
        <th>Email</th>
        <th>Clients</th>
        <th>Invoices</th>
      </thead>
      <tbody>
        @foreach($users as $user)
        <tr>
          <td class="vcenter">{{ $user->name }}</td>
          <td class="vcenter">{{ $user->email }}</td>
          <td class="vcenter">{{ $user->clients->count() }}</td>
          <td class="vcenter">{{ $user->invoices->count() }}</td>
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
