@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-6 col-sm-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="/auth/login" method="POST" role="form">
                        <legend>Sign In</legend>

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
                            <label for="email">Username</label>
                            <input class="form-control input-lg" type="email" name="email" id="email" value="{{ old('email') }}" tabindex="1" placeholder="ex@mp.le">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input class="form-control input-lg" type="password" name="password" id="password" tabindex="2">
                        </div>
                        <button type="submit" class="btn btn-default btn-lg" tabindex="3">Sign In</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
