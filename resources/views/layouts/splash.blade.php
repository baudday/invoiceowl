<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ getenv('APP_NAME') }}</title>
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link href='https://fonts.googleapis.com/css?family=Righteous|Open+Sans:400,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    @yield('head')
</head>
<body>

@include('layouts.partials.banner')

<div class="container body">
@yield('content')
</div>

<div class="container-fluid">
    <div class="row footer">
        <div class="col-xs-12">
            <small class="muted">Copyright &copy; {{ getenv('APP_NAME') }} {{ date('Y') }}. All Rights Reserved.</small>
            <br />
            <small>Icons by <a target="blank" href="https://icons8.com">Icons8</a> (<a target="blank" href="https://creativecommons.org/licenses/by-nd/3.0/">license</a>)</small>
        </div>
    </div>
</div>

@yield('body-scripts')
</body>
</html>