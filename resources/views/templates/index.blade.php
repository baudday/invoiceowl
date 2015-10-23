@extends('layouts.default')

@section('content')
<h1>Your Templates</h1>
<table class='table table-bordered table-hover'>
  <tbody>
    @foreach($templates as $template)
    <tr>
      <td style="text-align: center;"><a href="{{ route('dashboard.templates.show', $template->id) }}"><img src='{{ $template->thumbnail }}' width='77' height='100'></a></td>
      <td style="text-align: center; vertical-align: middle;">
        <form class="form-inline" method="post" action="{{ route('dashboard.templates.destroy', $template->id) }}">
          <a href="{{ route('dashboard.templates.edit', $template->id) }}" class="btn btn-sm btn-info">
            <span class="glyphicon glyphicon-pencil"></span> Edit
          </a>
          {!! method_field('DELETE') !!}
          {!! csrf_field() !!}
          <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this template? This cannot be undone.');">
            <span class="glyphicon glyphicon-trash"></span> Delete
          </button>
        </form>
      </td>
    </tr>
    @endforeach
    @if (\Auth::user()->isAdmin())
    <tr>
      <td colspan="4" align="center">
        <a href="{{ route('dashboard.templates.create') }}" class="btn btn-lg btn-default">
          <span class="glyphicon glyphicon-plus"></span> New Template
        </a>
      </td>
    </tr>
    @endif
  </tbody>
</table>
@stop
