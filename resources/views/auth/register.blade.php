@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-lg-offset-1 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="/auth/register" method="POST" role="form">
                        <legend>Register for InvoiceOwl</legend>

                        @include('layouts.partials.errors')

                        {!! csrf_field() !!}

                        <div class='form-group'>
                            <label for='logo'>Logo (Optional)</label>
                            <br />
                            <div class='logo-img-container'>
                                <img id='logo_img' src='{{ old("logo") ?: "//placehold.it/200x200" }}' />
                            </div>
                            <br />
                            <div class="img-error" style="display:none;">
                                <small class="alert alert-danger img-error-message"></small>
                            </div>
                            <input type='file' id='_logo' style='display:none;'>
                        </div>
                        <input type="hidden" id='logo' name="logo" value="{{ old('logo') }}">

                        <hr>

                        <div class="row">
                          <div class="col-sm-10">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control input-lg" id="name" placeholder="Joe Namath" value="{{ old('name') }}">
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                                <label for="currency">Currency</label>
                                <input type="text" name="currency" class="form-control input-lg" id="currency" placeholder="$" value="{{ old('currency') ?: '$' }}">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-xs-12">
                            <div class='form-group'>
                              <label for='company_name'>Company Name (Optional)</label>
                              <input type='text' name='company_name' class='form-control input-lg' value="{{ old('company_name') }}" placeholder="Acme Corp" data-toggle="tooltip" data-placement="left" title="If set, we will use this instead of your name on invoices">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-xs-12">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control input-lg" id="email" placeholder="ex@mp.le" value="{{ old('email') }}">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-xs-12">
                            <div class="form-group">
                                <label for="phone_number">Phone Number (Optional)</label>
                                <input type="phone_number" name="phone_number" class="form-control input-lg" id="phone_number" placeholder="9185551234" value="{{ old('phone_number') }}">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-xs-12">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control input-lg" id="password">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-xs-12">
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control input-lg" id="password_confirmation">
                            </div>
                          </div>
                        </div>

                        <button type="submit" class="btn btn-default btn-lg">Register</button> or <a href="/auth/login">Sign In</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('body-scripts')
  <script type="text/javascript">
    var reader = new FileReader();
    reader.onloadend = function() {
      var href = '{{ route("api.v1.users.update") }}';
      $.ajax({
        type: 'put',
        url: href,
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        data: {
          logo: reader.result
        }
      }).success(function(body) {
        $('#logo_img').attr('src', body.url);
        $('#logo').val(body.url);
      });
    };

    $(function() {
      $('#logo_img').on('click', function() {
        $('.img-error').hide();
        $('#_logo').click();
      });

      $('#_logo').on('change', function() {
        var file = $('#_logo').prop('files')[0];

        if (file) {
          if (!file.type.match(/image.*/)) {
            showError('Please only upload images');
            return;
          }

          if (file.size > 2000000) {
            showError('Files must be under 2MB. Yours is ' + Math.round(file.size/2000000*100)/100 + 'MB');
            return;
          }

          $('#logo_img').attr('src', '/img/loader.gif');
          reader.readAsDataURL(file);
        }

      });

      $('[data-toggle="tooltip"]').tooltip();
    });

    function showError(msg) {
      $('.img-error-message').text(msg);
      $('.img-error').show();
    }
  </script>
@stop
