@extends('layouts.homeApp')
@section('content')
<div class="container">
  <div class="row">
<div class="col-lg-12 col-md-12 col-sm-12">
  <section style="width: 100%;height: auto;max-width: 650px;min-width: 290px;text-align: center;margin: auto;margin-bottom: 50px;">
  <center><img src="/public/images/icon/logo.svg" alt="Logo" class="home-logo" style="width: 300px;"></center>
  <hr>
  <div class="form-top-title">Register Account</div>
  <div class="form-style shadow-lg">
    <form action="/signup-account" method="post" class="form-design" id="Signup-Form">
      {{ csrf_field() }}
      <div class="row">
        <div class="col-6">
          <div class="form-group input-effect-wrapper">
              <input type="text" class="form-control input-effect" placeholder="" required name="fname" value="{{ old('fname') }}">
              <label>First Name<span class="zred">*</span></label>
              <span class="focus-border"></span>
          </div>
        </div>

        <div class="col-6">
          <div class="form-group input-effect-wrapper">
              <input type="text" class="form-control input-effect" placeholder="" required name="lname" value="{{ old('lname') }}">
              <label>Last Name<span class="zred">*</span></label>
              <span class="focus-border"></span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="form-group input-effect-wrapper">
              <input type="email" class="form-control input-effect {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="" required name="email" value="{{ old('email') }}">
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
      <br>
      <button type="submit" class="btn btn-lg btn-block form-btn">
      Sign Up</button>
      <br><br>
      <div style="float: right;">Already have account ? <a href="/login" class="login-link">Sign in</a></div>


    </form>
    </div>
  </section>
</div>
</div> <!-- row end -->
</div> <!-- end container -->     
@endsection