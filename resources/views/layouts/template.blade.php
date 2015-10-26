<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      <?php include( base_path('public/css/app.css') ); ?>
      @yield('styles')
    </style>
</head>
<body>

<div class="container body">
  <div class='row'>
    <div class='col-xs-12'>
      @yield('body')
    </div>
  </div>
</div>
</body>
</html>
