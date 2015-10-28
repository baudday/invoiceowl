<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ getenv('APP_NAME') }} @yield('title')</title>
    <link rel="stylesheet" type="text/css" href="/css/app.css" charset="utf-8">
    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>

@include('layouts.partials.nav')

<div class="container wrapper">
  <div class='row'>
    <div class='col-lg-2 col-md-2 col-sm-4 col-xs-12'>
      @include('layouts.partials.menu')
    </div>
    <div class='col-lg-10 col-md-10 col-sm-8 col-xs-12'>
      @yield('content')
    </div>
  </div>
  @yield('outside')
  <div class="push"></div>
</div>

<footer class="footer container">
    <div class="row">
        <div class="col-xs-12">
            <small class="muted">Copyright &copy; {{ getenv('APP_NAME') }} {{ date('Y') }}. All Rights Reserved.</small>
        </div>
    </div>
</div>

@yield('body-scripts')
</body>
</html>
