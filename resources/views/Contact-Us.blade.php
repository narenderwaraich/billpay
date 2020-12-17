@extends('layouts.homeApp')
@section('content')
<div class="container">
  <div class="row">
<div class="col-lg-12 col-md-12 col-sm-12">
  <section style="width: 100%;height: auto;max-width: 650px;min-width: 290px;text-align: center;margin: auto;margin-bottom: 50px;">
  <center><img src="/public/images/icon/logo.svg" alt="Logo" class="home-logo" style="width: 300px;"></center>
  <hr>
  <div class="form-top-title">CONTACT US</div>
  <div class="form-style shadow-lg">
    <form action="/contact-us" method="post" class="form-design">
      {{ csrf_field() }}
      <div class="row">
        <div class="col-6">
          <div class="form-group input-effect-wrapper">
              <input type="text" class="form-control input-effect" placeholder="" required name="name" value="{{ old('name') }}">
              <label>Name<span class="zred">*</span></label>
              <span class="focus-border"></span>
          </div>
        </div>

        <div class="col-6">
          <div class="form-group input-effect-wrapper">
              <input type="number" class="form-control input-effect" maxlength="10" minlength="10" placeholder="" required name="phone" value="{{ old('phone') }}">
              <label>Phone<span class="zred">*</span></label>
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
              <textarea class="form-control input-effect" rows="4"  name="message"  placeholder="" required></textarea>
              <label>Message<span class="zred">*</span></label>
              <span class="focus-border"></span>
          </div>
        </div>
      </div>
      <br>
      <button type="submit" class="btn btn-lg btn-block form-btn">
      Send</button>
    </form>
    </div>
  </section>
</div>
</div> <!-- row end -->
</div> <!-- end container -->     
@endsection