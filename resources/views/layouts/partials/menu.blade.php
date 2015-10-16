@if(Auth::check())
<ul class="nav nav-pills nav-stacked">
  <li role="presentation"><a href="{{ route('dashboard') }}"><span class="glyphicon glyphicon-home"></span> Home</a></li>
  <li role="presentation"><a href="{{ route('dashboard.clients.index') }}"><span class="glyphicon glyphicon-user"></span> Clients</a></li>
  <li role="presentation"><a href="{{ route('dashboard.invoices.index') }}"><span class="glyphicon glyphicon-usd"></span> Invoices</a></li>
  <li role="presentation"><a href="{{ route('dashboard.templates.index') }}"><span class="glyphicon glyphicon-duplicate"></span> Templates</a></li>
  <li role="presentation"><a href="{{ route('dashboard.settings.index') }}"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
</ul>
@endif
