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
        <img id='logo_img' src='{{ $settings->logo }}' />
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

      <div class='form-group'>
        <label for='name'>Name</label>
        <input type='text' name='name' class='form-control input-lg' value='{{ $settings->name }}' required>
      </div>

      <div class='form-group'>
        <label for='email'>Email</label>
        <input type='email' name='email' class='form-control input-lg' value='{{ $settings->email }}' disabled>
      </div>

      <div class='form-group'>
        <label for='name'>Phone Number</label>
        <input type='text' name='phone_number' class='form-control input-lg' value='{{ $settings->phone_number }}'>
      </div>

      <div class='form-group'>
          <button type='submit' class='btn btn-lg btn-default'><span class="glyphicon glyphicon-floppy-save"></span> Save</button>
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
    });

    function showError(msg) {
      $('.img-error-message').text(msg);
      $('.img-error').show();
    }
  </script>
@stop
