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

<div class="container">
  <div class="row vertical-align">
    <div class="col-xs-12">
      @yield('content')
    </div>
  </div>
</div>

</body>
</html>
