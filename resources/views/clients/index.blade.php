@extends('layouts.default')

@section('title') | Clients @stop

@section('content')
<h1>Your Clients</h1>
<table class='table table-bordered table-hover'>
  <tbody>
    @foreach($clients as $client)
    <tr>
      <td class="col-xs-2" style="text-align: center;">
        <a href="{{ route('dashboard.clients.invoices.create', $client->id) }}" class="btn btn-sm btn-success">
          <span class="glyphicon glyphicon-usd"></span> Invoice</span>
        </a>
      </td>
      <td class="col-xs-4"><a href="{{ route('dashboard.clients.show', $client->id) }}">{{ $client->name }}</a></td>
      <td class="col-xs-4">{{ $client->email }}</td>
      <td class="col-xs-2" style="text-align: center;">
        <form class="form-inline" method="post" action="{{ route('dashboard.clients.destroy', $client->id) }}">
          <a href="{{ route('dashboard.clients.edit', $client->id) }}" class="btn btn-sm btn-info">
            <span class="glyphicon glyphicon-pencil"></span> Edit
          </a>
          {!! method_field('DELETE') !!}
          {!! csrf_field() !!}
          <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this client? This cannot be undone.');">
            <span class="glyphicon glyphicon-trash"></span> Delete
          </button>
        </form>
      </td>
    </tr>
    @endforeach
    <tr>
      <td colspan="4" align="center">
        <a href="{{ route('dashboard.clients.create') }}" class="btn btn-lg btn-default">
          <span class="glyphicon glyphicon-plus"></span> New Client
        </a>
      </td>
    </tr>
  </tbody>
</table>
@stop
