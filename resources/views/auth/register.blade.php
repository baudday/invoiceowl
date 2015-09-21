@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="/auth/register" method="POST" role="form">
                        <legend>Register</legend>

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Oops!</strong>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </div>
                        @endif

                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control input-lg" id="name" placeholder="Sagar Sawant" value="{{ old('name') }}">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control input-lg" id="email" placeholder="ex@mp.le" value="{{ old('email') }}">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control input-lg" id="password">
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control input-lg" id="password_confirmation">
                        </div>

                        <button type="submit" class="btn btn-default btn-lg">Register</button> or <a href="/auth/login">Sign In</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
