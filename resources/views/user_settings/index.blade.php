@extends('layouts.default')

@section('content')
<h1>User Settings</h1>

<div class='row '>

  <div class='col-lg-8 col-md-8 col-sm-12 col-xs-12 col-lg-offset-2 col-md-offset-2'>

    @include('layouts.partials.errors')

    @if(session('success'))
    <div class="alert alert-success">
      <strong>Yay!</strong>
      {{ session('success') }}
    </div>
    @endif

    <div class='form-group'>
      <label for='logo'>Logo (Click to change)</label>
      <br />
      <div class='logo-img-container'>
        <img id='logo_img' src='{{ $settings->logo ?: "//placehold.it/200x200" }}' />
      </div>
      <br />
      <div class="img-error" style="display:none;">
        <small class="alert alert-danger img-error-message"></small>
      </div>
      <input type='file' id='_logo' style='display:none;'>
    </div>

    <hr>

    <form action="{{ route('dashboard.settings.update', \Auth::user()->id) }}" method="post">

      {!! method_field('PUT') !!}
      {!! csrf_field() !!}

      <input type="hidden" id='logo' name="logo" value="{{ $settings->logo }}">

      <div class="row">
        <div class="col-sm-10">
          <div class='form-group'>
            <label for='name'>Name</label>
            <input tabindex="1" type='text' name='name' class='form-control input-lg' value='{{ $settings->name }}' required>
          </div>
        </div>
        <div class="col-sm-2">
          <div class='form-group'>
            <label for='name'>Currency</label>
            <input tabindex="1" type='text' name='currency' class='form-control input-lg' value='{{ $settings->currency }}' required>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <div class='form-group'>
            <label for='company_name'>Company Name (Optional)</label>
            <input tabindex="1" type='text' name='company_name' class='form-control input-lg' value='{{ $settings->company_name }}' placeholder="Acme Corp" data-toggle="tooltip" data-placement="top" title="If set, we will use this instead of your name on invoices">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <div class='form-group'>
            <label for='email'>Email</label>
            <input tabindex="1" type='email' name='email' class='form-control input-lg' value='{{ $settings->email }}' disabled>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <div class='form-group'>
            <label for='name'>Phone Number</label>
            <input tabindex="1" type='text' name='phone_number' class='form-control input-lg' value='{{ $settings->phone_number }}' placeholder="9185551234">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <label>Address (Optional)</label>
          <div class="form-group">
            <label for="line_one">Line 1</label>
            <input tabindex="1" type="text" name="line_one" class="form-control input-lg" id="line_one" placeholder="123 Fake St." value="{{ $settings->address->line_one }}">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="form-group">
            <label for="line_two">Line 2</label>
            <input tabindex="1" type="text" name="line_two" class="form-control input-lg" id="line_two" placeholder="Apt. 2F" value="{{ $settings->address->line_two }}">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-4">
          <div class="form-group">
            <label for="city">City</label>
            <input tabindex="1" type="text" name="city" class="form-control input-lg" id="city" placeholder="Tulsa" value="{{ $settings->address->city }}">
          </div>
        </div>
        <div class="col-xs-4">
          <div class="form-group">
            <label for="state">State/Province</label>
            <input tabindex="1" type="text" name="state" class="form-control input-lg" id="state" placeholder="OK" value="{{ $settings->address->state }}">
          </div>
        </div>
        <div class="col-xs-4">
          <div class="form-group">
            <label for="zip">Zip</label>
            <input tabindex="1" type="text" name="zip" class="form-control input-lg" id="zip" placeholder="90210" value="{{ $settings->address->zip }}">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="form-group">
            <label for="country">Country</label>
            <input tabindex="1" type="text" name="country" class="form-control input-lg" id="country" placeholder="United States" value="{{ $settings->address->country }}">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <div class='form-group'>
              <button tabindex="1" type='submit' class='btn btn-lg btn-default'><span class="glyphicon glyphicon-floppy-save"></span> Save</button>
          </div>
        </div>
      </div>

    </form>

  </div>

</div>
@stop

@section('body-scripts')
  <script type="text/javascript">
    var reader = new FileReader();
    reader.onloadend = function() {
      var href = '{{ route("api.v1.settings.update", \Auth::user()->id) }}';
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
