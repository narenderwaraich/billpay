@extends('layouts.homeApp')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <section style="width: 100%;height: auto;max-width: 650px;min-width: 290px;text-align: center;margin: auto;">
        <center><img src="" alt="Logo" class="home-logo"></center>
        <div class="home-title">Online Bill</div>
        <div class="home-title-2">Go Paperless Invoices</div>
        <hr>
        <div class="form-top-title">Forget Password</div>
        <div class="form-style shadow-lg">
          <div class="login-title">Lost Password</div>
              <form method="post" action="/forget-password" style="margin-top: 20px">
                        {{ csrf_field() }}
                  <div class="form-group">
                      <input type="email" class="form-control form-input {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="Email" required>
                  @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                  @endif
                  </div>
                  <br>
                  <button type="submit" class="btn form-btn btn-lg btn-block">
                  Submit</button>
                  <br><br>
                  <div style="float: right;">Don't have account ? <a href="/SignUp" class="sign-up-link">Sign Up Here</a>
                  </div>  
              </form>
      </div>
    </div>
  </div> <!-- row end -->
</div> <!-- end container -->
  @endsection
