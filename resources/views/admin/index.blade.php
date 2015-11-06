@extends('layouts.admin')

@section('content')
@if(count($emails) > 0)
<div class="row">
  <div class="col-xs-12">
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
</div>
@endif

<div class="row">
  <div class="col-xs-12">
    <h1>Fancy Charts</h1>
    <hr>
  </div>
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-body">
        <h3 style="text-align:center;">Registered Users</h3>
        <hr>
        <canvas style="width: 100%;" id="users_line"></canvas>
        <hr>
        <h4 style="text-align:center;">{{ end($users) }} registered users</h4>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-body">
        <h3 style="text-align:center;">Usage</h3>
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
    <div class="panel panel-default">
      <div class="panel-body">
        <h3 style="text-align:center;">User Breakdown</h3>
        <hr>
        <canvas style="width: 100%;" id="users_donut"></canvas>
        <hr>
        <h4 style="text-align:center;">
          {{ number_format(((count($users))/(count($users) + $unregistered_count)) * 100, 2) }}%
          response rate
        </h4>
      </div>
    </div>
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
    var data = {
    labels: {!! json_encode(array_keys($usage)) !!},
    datasets: [
        {
          label: "Registered Users",
          fillColor: "rgba(191, 77, 40, 0.2)",
          strokeColor: "rgba(191, 77, 40, 1)",
          pointColor: "rgba(191, 77, 40, 1)",
          pointStrokeColor: "#fff",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(191, 77, 40, 1)",
          data: {!! json_encode(array_values($users)) !!}
        }
      ]
    };

    var lineCtx = document.getElementById("users_line").getContext("2d");
    new Chart(lineCtx).Line(data);

    var data = [
      {
        value: {{ $user_count }},
        color: "#BF4D28",
        highlight: "#BF4D28",
        label: "Registered Users"
      },
      {
        value: {{ $unregistered_count }},
        color:"#ccc",
        highlight: "#ccc",
        label: "Unregistered Users"
      },
      {
        value: {{ count($emails) }},
        color: "#FDB45C",
        highlight: "#FDB45C",
        label: "Requested Invites"
      }
    ];

    var donutCtx = document.getElementById("users_donut").getContext("2d");
    new Chart(donutCtx).Doughnut(data, {
      animateScale: true
    });

    var data = {
    labels: {!! json_encode(array_keys($usage)) !!},
    datasets: [
        {
          label: "Total Clients",
          fillColor: "rgba(220, 200, 220, 0.2)",
          strokeColor: "rgba(220, 200, 220, 1)",
          pointColor: "rgba(220, 200, 220, 1)",
          pointStrokeColor: "#fff",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220, 200, 220, 1)",
          data: {!! json_encode(array_values($clients)) !!}
        },
        {
          label: "Invoices Sent",
          fillColor: "rgba(191, 77, 40, 0.2)",
          strokeColor: "rgba(191, 77, 40, 1)",
          pointColor: "rgba(191, 77, 40, 1)",
          pointStrokeColor: "#fff",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(191, 77, 40, 1)",
          data: {!! json_encode(array_values($usage)) !!}
        }
      ]
    };

    var lineCtx = document.getElementById("usage_chart").getContext("2d");
    new Chart(lineCtx).Line(data);
</script>
@stop
