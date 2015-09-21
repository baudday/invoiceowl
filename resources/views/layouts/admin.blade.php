<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ getenv('APP_NAME') }} | Admin</title>
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>

@include('layouts.partials.nav')

<div class="container">
    <div class="row">
        <div class="col-sm-2">
            <a href="/admin" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-home"></span> Home</a>
        </div>
        <div class="col-sm-8">
            @yield('content')
        </div>
    </div>
</div>

@yield('body-scripts')
</body>
</html>
