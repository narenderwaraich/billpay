@extends('layouts.homeApp')
@section('content')
<nav class="navbar navbar-expand-lg navbar-dark static-top nav-bottom-border fix-navbar bg-black-color">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">
      <img src="" alt="Logo" class="nav-logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto nav-m-r">
        <li class="nav-item nav-text">
          <a class="nav-link white-txt on-hover-color" href="/about-us">About Us</a>
        </li>
        <li class="nav-item nav-text">
          <a class="nav-link white-txt on-hover-color" href="/contact-Us">Contact Us</a>
        </li>
        <li class="nav-item nav-text">
          <a class="nav-link white-txt on-hover-color" href="/login">Login</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container" style="margin-top: 120px;">
  <div class="row">
<div class="col-lg-4 col-md-4 col-sm-12">
  <center><img src="" alt="Logo" class="home-logo"></center>
  <div class="home-title">Online Bill</div>
  <div class="home-title-2">Go Paperless Invoices</div>
</div>

<div class="col-lg-8 col-md-8 col-sm-12">
  <div class="form-top-title">Signup Account</div>
  <div class="form-style shadow-lg">
    <form action="/SignUp" method="post">
      {{ csrf_field() }}
      <div class="row">
        <div class="col-12">
          <div class="form-group">
            <input type="text" class="form-control " name="fname" id="fname" placeholder="First Name" required value="{{ old('fname') }}">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="form-group">
            <input type="text" class="form-control " name="lname" placeholder="Last Name" required value="{{ old('lname') }}">
          </div>
        </div>
      </div>
      <div class="form-group">
        <input type="email" name="email" class="form-control  {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" value="{{ old('email') }}" required>
        @if ($errors->has('email'))
        <span class="invalid-feedback" role="alert">
          <strong>{{ $errors->first('email') }}</strong>
        </span>
        @endif
      </div>
      <div class="row">
        <div class="col-12">
          <div class="form-group">
            <input id="password-field" type="password" class="form-control " name="password" placeholder="Password" required>
            <span toggle="#password-field" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
          </div>
        </div>
      </div>
      <!-- <input type="checkbox" onclick="myFunction()"> &nbsp; <b>Show Password</b> -->
      <br>
      <button type="submit" class="btn btn-lg btn-block form-btn">
      Sign Up</button>
      <br><br>
      <div style="float: right;">Already have account ? <a href="/login" class="login-link">Sign in</a></div>


    </form>
  </div>
</div>
</div> <!-- row end -->
</div> <!-- end container -->     
@endsection