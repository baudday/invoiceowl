@extends('layouts.default')

@section('content')
<h1>New Template</h1>

<div class='row '>

  <div class='col-lg-8 col-md-8 col-sm-12 col-xs-12 col-lg-offset-2 col-md-offset-2'>

    @include('layouts.partials.errors')

    <div class='form-group'>
      <label for='template'>Thumbnail (Click to change)</label>
      <br />
      <div class='template-img-container'>
        <img id='template_img' src='//placehold.it/154x200' />
      </div>
      <br />
      <div class="img-error" style="display:none;">
        <small class="alert alert-danger img-error-message"></small>
      </div>
      <input type='file' id='_template' style='display:none;'>
    </div>

    <hr>

    <form action="{{ route('dashboard.templates.store') }}" method="post">
      {!! csrf_field() !!}

      <input type="hidden" id='template' name="thumbnail">

      <div class='form-group'>
        <label for='name'>Body</label>
        <textarea name='body' class='form-control input-lg' placeholder='HTML' rows="10" required>{!! old('body') !!}</textarea>
      </div>

      <div class='form-group'>
          <button type='submit' class='btn btn-lg btn-default'>Create</button>
      </div>
    </form>

  </div>

</div>
@stop

@section('body-scripts')
  <script type="text/javascript">
    var reader = new FileReader();
    reader.onloadend = function() {
      var href = '{{ route("api.v1.templates.store") }}';
      $.ajax({
        type: 'post',
        url: href,
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        data: {
          thumbnail: reader.result
        }
      }).success(function(body) {
        $('#template_img').attr('src', body.url);
        $('#template').val(body.url);
      });
    };

    $(function() {
      $('#template_img').on('click', function() {
        $('.img-error').hide();
        $('#_template').click();
      });

      $('#_template').on('change', function() {
        var file = $('#_template').prop('files')[0];

        if (file) {
          if (!file.type.match(/image.*/)) {
            showError('Please only upload images');
            return;
          }

          if (file.size > 2000000) {
            showError('Files must be under 2MB. Yours is ' + Math.round(file.size/2000000*100)/100 + 'MB');
            return;
          }

          $('#template_img').attr('src', '/img/loader.gif');
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
