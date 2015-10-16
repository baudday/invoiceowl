@extends('layouts.default')

@section('content')
<h1>{{ $client->name }} <small>{{ $client->email }}</small></h1>
<hr>

<h2>Invoices</h2>
<table class='table table-bordered '>
  <thead>
    <tr>
      <th>#</th>
      <th>Description</th>
      <th>Amount</th>
      <th>Date</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>
@stop
