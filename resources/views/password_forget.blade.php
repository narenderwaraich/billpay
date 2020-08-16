@extends('layouts.homeApp')
@section('content')
 <nav class="navbar navbar-expand-lg navbar-dark static-top nav-bottom-border fix-navbar">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">
          <img src="/images/mapleebooks_logo.svg" alt="Logo" class="nav-logo">
        </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto nav-m-r">
        <li class="nav-item">
          <a class="nav-link nav-text" href="/about-us">About US</a>
        </li>
        <li class="nav-item nav-text">
          <a class="nav-link" href="/Contact-Us">Contact Us</a>
        </li>
        <li class="nav-item nav-text">
          <a class="nav-link" href="/SignUp">SignUp</a>
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
      <img src="/images/signup-card.png" alt="Los Angeles">
    </div>
    <div class="carousel-item">
      <img src="/images/add-clients.png" alt="Chicago">
    </div>
    <div class="carousel-item">
      <img src="/images/create-invoice.png" alt="New York">
    </div>
    <div class="carousel-item">
      <img src="/images/get-paid-online.png" alt="New York">
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
      <center><img src="/images/mapleebooks_logo.svg" alt="Logo" class="home-logo"></center>
      <div class="home-title">Maple Ebooks</div>
      <div class="home-title-2">Go Paperless with Maple ebooks</div>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-12">
      <div class="form-top-title">Signup for free 30 days trail</div>
      <div class="form-style shadow-lg">
        <div class="login-title">Forget Password</div>
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
                        <div style="float: right;">Don't have account ? <a href="/SignUp" class="sign-up-link">Sign Up Here</a></div>
                        
                        
                       
                    </form>
                  </div>
    </div>
  </div> <!-- row end -->
  <div class="text-home">
    Key Features
  </div>
</div> <!-- end container -->

      <div class="container-fluid iphone-div">
        <div class="container iphone-div2">
          <div class="row">
            <div class="col-md-4">
              <div class="iphone">
                <img src="/images/dashboard-edit-client-mobile.png" class="ipn-img">
              </div>
            </div>

            <div class="col-md-8">
              <div class="row key-text">
                <div class="col-md-1 col-xs-4 col-sm-2 col-lg-1 home-tick-icon"><img src="/images/tick-icon.svg"></div>
                <div class="col-xs-8 col-sm-10 col-lg-11 col-md-11">CLOUD BASED INVOICE SYSTEM</div>
                <div class="col-md-1 col-xs-4 col-sm-2 col-lg-1 home-tick-icon"><img src="/images/tick-icon.svg"></div>
                <div class="col-xs-8 col-sm-10 col-lg-11 col-md-11">EASY SIGN UP</div>
                <div class="col-md-1 col-xs-4 col-sm-2 col-lg-1 home-tick-icon"><img src="/images/tick-icon.svg"></div>
                <div class="col-xs-8 col-sm-10 col-lg-11 col-md-11">ADD YOUR CLIENTS WITH EASE</div>
                <div class="col-md-1 col-xs-4 col-sm-2 col-lg-1 home-tick-icon"><img src="/images/tick-icon.svg"></div>
                <div class="col-xs-8 col-sm-10 col-lg-11 col-md-11">EASY CONNECT WITH YOUR STRIPE ACCOUNT TO RECEIVE</div>
                <div class="col-md-1 col-xs-4 col-sm-2 col-lg-1 home-tick-icon"><img src="/images/tick-icon.svg"></div>
                <div class="col-xs-8 col-sm-10 col-lg-11 col-md-11">PAYMENTS ONLINE</div>
                <div class="col-md-1 col-xs-4 col-sm-2 col-lg-1 home-tick-icon"><img src="/images/tick-icon.svg"></div>
                <div class="col-xs-8 col-sm-10 col-lg-11 col-md-11">CREATE INVOICE AND SEND TO YOUR CLIENT BY EMAIL</div>
                <div class="col-md-1 col-xs-4 col-sm-2 col-lg-1 home-tick-icon"><img src="/images/tick-icon.svg"></div>
                <div class="col-xs-8 col-sm-10 col-lg-11 col-md-11">GET PAID ONLINE USING CREDIT CARD OR DEBIT CARD</div>
                <div class="col-md-1 col-xs-4 col-sm-2 col-lg-1 home-tick-icon"><img src="/images/tick-icon.svg"></div>
                <div class="col-xs-8 col-sm-10 col-lg-11 col-md-11">DOWNLOAD YOUR INVOICES TO YOUR SYSTEM AT YOUR EASE</div>
                <div class="col-md-1 col-xs-4 col-sm-2 col-lg-1 home-tick-icon"><img src="/images/tick-icon.svg"></div>
                <div class="col-xs-8 col-sm-10 col-lg-11 col-md-11">EASY CONNECT WITH YOUR STRIPE ACCOUNT TO RECEIVE PAYMENTS ONLINE</div>
                <div class="col-md-1 col-xs-4 col-sm-2 col-lg-1 home-tick-icon"><img src="/images/tick-icon.svg"></div>
                <div class="col-xs-8 col-sm-10 col-lg-11 col-md-11">FULLY RESPONSIVE WEB APP ACCESS FROM MOBILE ANY TIME</div>             
              </div>
            </div>
          </div> 
        </div>
      </div>

      <div class="container">
        <div class="text-home">Our Plan</div>
        <div class="row">
          <div class="col-md-4">
            <div class="plan-box">
              <div class="plan-internel-box">
                <div class="plan-box-text" style="padding-bottom: 10px;">
                  Basic<br>Plan
                  <br>
                  8 $ <span class="plan-box-text2">Per Month</span>
                </div>
              </div>

              <div class="plan-feature-text">
                <i class="fa fa-star str-css"></i>Up to 5 clients <br>
                <i class="fa fa-star str-css"></i>Unlimited invoices <br>
                <i class="fa fa-star str-css"></i>online payment <br>
                <i class="fa fa-star str-css"></i>download to pdf <br>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="plan-box">
              <div class="plan-internel-box">
                <div class="plan-box-text" style="padding-bottom: 10px;">
                  Professional<br>Plan
                  <br>
                  15 $ <span class="plan-box-text2">Per Month</span>
                </div>
              </div>

              <div class="plan-feature-text">
                <i class="fa fa-star str-css"></i>Up to 10 clients <br>
                <i class="fa fa-star str-css"></i>Unlimited invoices <br>
                <i class="fa fa-star str-css"></i>online payment <br>
                <i class="fa fa-star str-css"></i>download to pdf <br>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="plan-box">
              <div class="plan-internel-box">
                <div class="plan-box-text">
                  Enterpries<br>Plan
                  <br>
                  <button type="button" class="btn plan-box-btn">Contact Us</button>
                </div>
              </div>

              <div class="plan-feature-text">
                <i class="fa fa-star str-css"></i>custom clients <br>
                <i class="fa fa-star str-css"></i>Unlimited invoices <br>
                <i class="fa fa-star str-css"></i>online payment <br>
                <i class="fa fa-star str-css"></i>download to pdf <br>
              </div>
            </div>
          </div>
        </div>
      </div>


  @endsection
