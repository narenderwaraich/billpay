@extends('layouts.homeApp')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <section style="width: 100%;height: auto;max-width: 650px;min-width: 290px;text-align: center;margin: auto;margin-bottom: 50px;">
        <center><img src="/public/images/icon/logo.svg" alt="Logo" class="home-logo" style="width: 300px;"></center>
        <hr>
        <div class="form-top-title">SignIn Account</div>
        <div class="form-style shadow-lg">
          <div class="login-title">Login</div>
          <form action="/login" method="post" class="form-design" id="login-form">
            {{ csrf_field() }}
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group input-effect-wrapper">
                          <input type="email" class="form-control input-effect {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="" id="username" required name="email" value="{{ old('email') }}">
                          <label>Email<span class="zred">*</span></label>
                          <span class="focus-border"></span>
                          @if ($errors->has('email'))
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                          </span>
                          @endif
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group input-effect-wrapper">
                          <input type="password" class="form-control input-effect" id="password-field" placeholder="" required name="password" value="">
                          <label>Password<span class="zred">*</span></label>
                          <span class="focus-border"></span>
                          <span toggle="#password-field" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                      </div>
                    </div>
                  </div>

                  
            <div class="checkbox">
              <label class="remember-label">
                <input type="checkbox" name="remember" id="remember" checked style="height: unset;"> Remember Me
              </label>
              <label class="pull-right">
                <a href="/forget-password" class="forget-password-text">Forgotten Password?</a>
              </label>
            </div><br>
            <button type="button" id="login-btn" class="btn form-btn btn-lg btn-block">
            Submit</button>
            <br><br>
            <div style="float: right;">Don't have account ? 
              <a href="/SignUp" class="sign-up-link">Sign Up Here</a>
            </div>
          </form>
      </div>
    </div>
  </div> <!-- row end -->
</div> <!-- end container --> 

<script>
  $('#login-btn').on('click', function() {
  // Store into cookies
  if ($('#remember').attr('checked')) {
  var username = $('#username').attr("value"); console.log(username);
  var password = $('#password-field').attr("value");
  // set cookies to expire in 14 days
  $.cookie('username', username, { expires: 14 });
  $.cookie('password', password, { expires: 14 });
  $.cookie('remember', true, { expires: 14 });
  } else {
  // reset cookies
  $.cookie('username', null);
  $.cookie('password', null);
  $.cookie('remember', null);
  }
  $('#login-form').submit();
});
// Read from cookies

var remember = $.cookie('remember'); //console.log(remember);
if ( remember == 'true' ) {
var username = $.cookie('username');
var password = $.cookie('password');
// autofill the fields
$('#username').attr("value", username);
$('#password-field').attr("value", password);
}

</script>

  @endsection