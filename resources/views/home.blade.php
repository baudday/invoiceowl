@extends('layouts.splash')

@section('banner-content')
<div class="col-sm-6 col-sm-offset-3">
    <h1>Send beautiful custom invoices effortlessly.</h1>
    @if(!\Auth::check())
    <h3>Request beta access or
      <a href="/dashboard" class="btn btn-lg btn-primary">
        <span class="glyphicon glyphicon-log-in"></span>
        Sign In
      </a>
    </h3>
    @endif
    @if ($errors->first('email'))
    <div class="alert alert-danger">
        {{ $errors->first('email') }}
    </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @elseif (isset($success))
    <div class="alert alert-success">
        {{ $success }}
    </div>
    @endif
    @if(!\Auth::check())
    <form action="/email" method="POST" role="form">
        {{ csrf_field() }}
        <div class="input-group">
            <input name="email" type="email" class="form-control input-lg" id="email" placeholder="ex@mp.le" value="{{ old('email') }}" required tabindex="1">
            <span class="input-group-btn">
                <button name="email_submit" type="submit" class="btn btn-default btn-lg" tabindex="1"><span class="glyphicon glyphicon-send"></span></button>
            </span>
        </div>
    </form>
    @endif
</div>
@stop

@section('content')
<div class="row">
    <div class="col-xs-12" style="text-align: center;">
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <h2>Features</h2>
        <hr>
        <div class="media">
            <div class="media-left media-middle">
                <img class="media-object" src="img/template.png" alt="" width="75">
            </div>
            <div class="media-body">
                <h4 class="media-heading">Pick a template</h4>
                We'll substitute in your logo along with the rest of your
                information to generate a custom PDF invoice to be sent to your
                client.
            </div>
        </div>

        <div class="media">
            <div class="media-left media-middle">
                <img class="media-object" src="img/message.png" alt="" width="75">
            </div>
            <div class="media-body">
                <h4 class="media-heading">We'll email your invoices for you</h4>
                When you're ready, hit send and we'll email your client a PDF
                copy of the invoice.
            </div>
        </div>

        <div class="media">
            <div class="media-left media-middle">
                <img class="media-object" src="img/dashboard.png" alt="" width="75">
            </div>
            <div class="media-body">
                <h4 class="media-heading">Track and manage your invoices</h4>
                Use our dashboard to keep track of which invoices you've sent,
                who's paid, and who hasn't.
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <h2>Plans</h2>
        <hr>
        <table class="table table-bordered" style="text-align: center;">
            <tbody>
                <tr>
                    <td></td>
                    <td>
                        <img src="img/plane.png" width="60" style="margin: 7px 0;">
                        <h3>Free</h3>
                    </td>
                    <td>
                        <img src="img/pro.png" width="75">
                        <h3>Pro</h3>
                    </td>
                </tr>
                <tr>
                    <td>Active clients</td>
                    <td>Up to 5</td>
                    <td class="success"><strong>Unlimited</strong></td>
                </tr>
                <tr>
                    <td>Invoices / month</td>
                    <td>Up to 5</td>
                    <td class="success"><strong>Unlimited</strong></td>
                </tr>
                <!-- <tr>
                    <td>Custom templates</td>
                    <td>None</td>
                    <td class="success"><strong>Unlimited</strong></td>
                </tr> -->
                <tr>
                    <td>{{ getenv('APP_NAME') }} watermark</td>
                    <td>Yes</td>
                    <td class="success"><strong>No</strong></td>
                </tr>
                <tr>
                    <td>Price / month</td>
                    <td><strong>Free</strong></td>
                    <td><s>$5</s> <strong>Free</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div id="contact" class="col-sm-8 col-sm-offset-2">
    <h1>Drop us a line</h1>
    <hr>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        @if ($errors->first('contact_email') || $errors->first('message'))
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="/contact" method="POST" role="form">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="contact_email">Email</label>
                <input name="contact_email" type="email" class="form-control input-lg" id="contact_email" placeholder="Email" value="{{ old('contact_email') }}" required tabindex="1">
            </div>

            <div class="form-group">
                <label for="">Message</label>
                <textarea name="message" id="message" class="form-control input-lg" rows="3" value="{{ old('message') }}" required tabindex="1"></textarea>
            </div>
            <button name="contact_submit" type="submit" class="btn btn-default btn-lg" tabindex="1">Send</button>
        </form>
    </div>
</div>
@stop

@section('body-scripts')
<script type="text/javascript">
$(window).scroll(function() {
  if ($(window).width() > 991) {
    var p = $('body').scrollTop();
    if (p >= 500) {
      $('.header').css({
        background: "url('../img/banner3.jpg') no-repeat center center fixed",
        'background-size': 'cover',
      });

      if ($('.header').data('size') == 'big') {
        $('.header').data('size', 'small');
        $('.logo').stop().animate({
          fontSize: '250%'
        });
        $('.social').stop().animate({
          lineHeight: '80px'
        });
        $('.social img').stop().animate({
          width: '25px'
        });
      }
    }
    else {
      $('.header').css({
        background: 'transparent'
      });

      if ($('.header').data('size') == 'small') {
        $('.header').data('size', 'big');
        $('.logo').stop().animate({
          fontSize: '300%'
        });
        $('.social').stop().animate({
          lineHeight: '85px'
        });
        $('.social img').stop().animate({
          width: '35px'
        });
      }
    }
  }
});
</script>
@stop
