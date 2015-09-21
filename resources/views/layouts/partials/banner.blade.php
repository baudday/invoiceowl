<div class="container-fluid banner">
  <div class="row header" data-size="big">
    <div class="col-xs-12">
      <div class="container">
        <div class="row" data-size="big">
          <div class="col-xs-12">
            <div class="pull-left">
              <h1 class="logo">{{ getenv('APP_NAME') }}</h1>
            </div>
            <div class="pull-right social">
              <a href="http://facebook.com/{{ getenv('FACEBOOK') }}" target="blank"><img src="img/facebook.png" /></a>
              <a href="http://twitter.com/{{ getenv('TWITTER') }}" target="blank"><img src="img/twitter.png" /></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row form-row">
    <div class="col-xs-12">
      <div class="container">
        <div class="row">
            @yield('banner-content')
        </div>
      </div>
    </div>
  </div>
</div>