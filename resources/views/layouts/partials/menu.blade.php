@if(Auth::check())
<ul class="nav nav-pills nav-stacked">
  <li role="presentation" class="{{ active_tab('dashboard') }}"><a href="{{ route('dashboard') }}"><span class="glyphicon glyphicon-home"></span> Home</a></li>
  <li role="presentation" class="{{ active_tab('dashboard.clients.index') }}"><a href="{{ route('dashboard.clients.index') }}"><span class="glyphicon glyphicon-user"></span> Clients</a></li>
  <li role="presentation" class="{{ active_tab('dashboard.invoices.index') }}"><a href="{{ route('dashboard.invoices.index') }}"><span class="glyphicon glyphicon-usd"></span> Invoices</a></li>
  @if(\Auth::user()->isAdmin())
  <li role="presentation" class="{{ active_tab('dashboard.templates.index') }}"><a href="{{ route('dashboard.templates.index') }}"><span class="glyphicon glyphicon-duplicate"></span> Templates</a></li>
  @endif
  <li role="presentation" class="{{ active_tab('dashboard.settings.index') }}"><a href="{{ route('dashboard.settings.index') }}"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
</ul>
@endif
