@extends('layouts.admin')

@section('content')
<div class="row">
  <div class="col-xs-12">
    <h1>Fancy Charts</h1>
    <hr>
  </div>
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-body">
        <h3 style="text-align:center;">User Breakdown</h3>
        <hr>
        <canvas style="width: 100%;" id="user_chart"></canvas>
        <hr>
        <h4 style="text-align:center;">
          {{ number_format(((count($users))/(count($users) + count($unregistered))) * 100, 2) }}%
          response rate
        </h4>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-body">
        <h3 style="text-align:center;">Usage Breakdown</h3>
        <hr>
        <canvas style="width: 100%;" id="usage_chart"></canvas>
        <hr>
        <h4 style="text-align:center;">
          {{ array_sum($usage) }} {{ str_plural('invoice') }} sent over the last 7 days
        </h4>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
      <h1>Requested Invites <span class="badge">{{ count($emails) }}</span></h1>
      <hr>
      <table class="table table-responsive table-bordered table-hover table-condensed">
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
  <div class="col-md-6">
    <h1>Unregistered Users <span class="badge">{{ count($unregistered) }}</span></h1>
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
    <h1>Registered Users <span class="badge">{{ count($users) }}</span></h1>
    <hr>
    <table class="table table-responsive table-bordered table-hover table-condensed">
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
        <table class="table table-responsive table-bordered">
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

@section('body-scripts')
<script type="text/javascript">
    var data = [
      {
        value: {{ count($users) }},
        color: "#46BFBD",
        highlight: "#5AD3D1",
        label: "Registered Users"
      },
      {
        value: {{ count($unregistered) }},
        color:"#F7464A",
        highlight: "#FF5A5E",
        label: "Unregistered Users"
      },
      {
        value: {{ count($emails) }},
        color: "#FDB45C",
        highlight: "#FFC870",
        label: "Requested Invites"
      }
    ];

    var donutCtx = document.getElementById("user_chart").getContext("2d");
    new Chart(donutCtx).Doughnut(data, {
      animateScale: true
    });

    var data = {
    labels: {!! json_encode(array_keys($usage)) !!},
    datasets: [
        {
          label: "Usage breakdown",
          fillColor: "rgba(220,220,220,0.2)",
          strokeColor: "rgba(220,220,220,1)",
          pointColor: "rgba(220,220,220,1)",
          pointStrokeColor: "#fff",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: {!! json_encode(array_values($usage)) !!}
        }
      ]
    };

    var lineCtx = document.getElementById("usage_chart").getContext("2d");
    new Chart(lineCtx).Line(data);
</script>
@stop
