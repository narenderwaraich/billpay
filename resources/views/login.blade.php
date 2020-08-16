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
      <div id="demo" class="carousel slide"  data-ride="carousel">

        <!-- Indicators -->
<!--  <ul class="carousel-indicators">
<li data-target="#demo" data-slide-to="0" class="active"></li>
<li data-target="#demo" data-slide-to="1"></li>
<li data-target="#demo" data-slide-to="2"></li>
</ul> -->

<!-- The slideshow -->
<div class="carousel-inner home-slider">
  <div class="carousel-item active">
    <img src="#" alt="Los Angeles">
  </div>
  <div class="carousel-item">
    <img src="#" alt="Chicago">
  </div>
  <div class="carousel-item">
    <img src="#" alt="New York">
  </div>
  <div class="carousel-item">
    <img src="#" alt="New York">
  </div>
</div>

<!-- Left and right controls -->
<!-- <a class="carousel-control-prev" href="#demo" data-slide="prev">
<span class="carousel-control-prev-icon"></span>
</a>
<a class="carousel-control-next" href="#demo" data-slide="next">
<span class="carousel-control-next-icon"></span>
</a> -->
</div>
</div>

<div class="col-lg-4 col-md-4 col-sm-12">
  <center><img src="" alt="Logo" class="home-logo"></center>
  <div class="home-title">Online Bill</div>
  <div class="home-title-2">Go Paperless Invoices</div>
</div>

    <div class="col-lg-4 col-md-4 col-sm-12">
      <div class="form-top-title">SignIn Account</div>
      <div class="form-style shadow-lg">
        <div class="login-title">Login</div>
      <form action="/login" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <input id="password-field" type="password" class="form-control" name="password" placeholder="Password" required>
                              <span toggle="#password-field" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember"> Remember Me
                            </label>
                            <label class="pull-right">
                                <a href="/forget-password" class="forget-password-text">Forgotten Password?</a>
                            </label>

                        </div><br>
                        <button type="submit" class="btn form-btn btn-lg btn-block">
                        Submit</button>
                        <br><br>
                        <div style="float: right;">Don't have account ? <a href="/SignUp" class="sign-up-link">Sign Up Here</a></div>
                        
                        
                       
                    </form>
                 </form>
  </div>
</div>
</div> <!-- row end -->
</div> <!-- end container --> 

  @endsection