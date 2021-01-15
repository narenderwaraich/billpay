@extends('layouts.homeApp')
@section('content')
<!-- home slider -->
<div id="homeSlider" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ul class="carousel-indicators">
    <li data-target="#homeSlider" data-slide-to="0" class="active"></li>
    <li data-target="#homeSlider" data-slide-to="1"></li>
    <li data-target="#homeSlider" data-slide-to="2"></li>
    <li data-target="#homeSlider" data-slide-to="3"></li>
    <li data-target="#homeSlider" data-slide-to="4"></li>
  </ul>

  <!-- The slideshow -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="/public/images/banner/dashboard.jpg" alt="Los Angeles">
      <div class="carousel-caption d-none d-md-block">
        <h5>...</h5>
        <p>...</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="/public/images/banner/client.jpg" alt="Chicago">
      <div class="carousel-caption d-none d-md-block">
        <h5>...</h5>
        <p>...</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="/public/images/banner/invoice.jpg" alt="New York">
      <div class="carousel-caption d-none d-md-block">
        <h5>...</h5>
        <p>...</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="/public/images/banner/payment.jpg" alt="New York">
      <div class="carousel-caption d-none d-md-block">
        <h5>...</h5>
        <p>...</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="/public/images/banner/item.jpg" alt="New York">
      <div class="carousel-caption d-none d-md-block">
        <h5>...</h5>
        <p>...</p>
      </div>
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="carousel-control-prev" href="#homeSlider" data-slide="prev">
    <i class="slider-control-prev-icon fa fa-chevron-left" aria-hidden="true"></i>
  </a>
  <a class="carousel-control-next" href="#homeSlider" data-slide="next">
    <i class="slider-control-next-icon fa fa-chevron-right" aria-hidden="true"></i>
  </a>
</div>
<!-- end home slider -->

<!-- start container --> 
<div class="container">
  <section class="logo-section">
    <center><img src="/public/images/icon/logo.svg" alt="Logo" class="home-logo" style="width: 300px;"></center>
    <div class="text-home">Features</div>
  </section>
</div> 
<!-- end container --> 

<div class="container-fluid invoice-feature-section">
        <div class="container" style="margin: 70px auto;">
          <div class="row">
            <div class="col-md-4">
              <div class="iphone">
                <img src="/public/images/banner/mobile-invoice.png" class="ipn-img">
              </div>
            </div>

            <div class="col-md-8">
              <div class="row feature-text">
                <div class="col-md-1 col-xs-4 col-sm-2 col-lg-1 w-10"><i class="fa fa-check feature-tik-icon" aria-hidden="true"></i></div>
                <div class="col-xs-8 col-sm-10 col-lg-11 col-md-11 w-90">All invoices in one place</div>
                <div class="col-md-1 col-xs-4 col-sm-2 col-lg-1 w-10"><i class="fa fa-check feature-tik-icon" aria-hidden="true"></i></div>
                <div class="col-xs-8 col-sm-10 col-lg-11 col-md-11 w-90">ONLINE INVOICE SYSTEM</div>
                <div class="col-md-1 col-xs-4 col-sm-2 col-lg-1 w-10"><i class="fa fa-check feature-tik-icon" aria-hidden="true"></i></div>
                <div class="col-xs-8 col-sm-10 col-lg-11 col-md-11 w-90">EASY REGISTER ACCOUNT</div>
                <div class="col-md-1 col-xs-4 col-sm-2 col-lg-1 w-10"><i class="fa fa-check feature-tik-icon" aria-hidden="true"></i></div>
                <div class="col-xs-8 col-sm-10 col-lg-11 col-md-11 w-90">CREATE INVOICE & SEND BY EMAIL</div>
                <div class="col-md-1 col-xs-4 col-sm-2 col-lg-1 w-10"><i class="fa fa-check feature-tik-icon" aria-hidden="true"></i></div>
                <div class="col-xs-8 col-sm-10 col-lg-11 col-md-11 w-90">DOWNLOAD YOUR INVOICES PDF</div>
                <div class="col-md-1 col-xs-4 col-sm-2 col-lg-1 w-10"><i class="fa fa-check feature-tik-icon" aria-hidden="true"></i></div>
                <div class="col-xs-8 col-sm-10 col-lg-11 col-md-11 w-90">MULTI DOWNLOAD YOUR INVOICES WITH ZIP</div> 
                <div class="col-md-1 col-xs-4 col-sm-2 col-lg-1 w-10"><i class="fa fa-check feature-tik-icon" aria-hidden="true"></i></div>
                <div class="col-xs-8 col-sm-10 col-lg-11 col-md-11 w-90">Add Your All Product Items</div>
                <div class="col-md-1 col-xs-4 col-sm-2 col-lg-1 w-10"><i class="fa fa-check feature-tik-icon" aria-hidden="true"></i></div>
                <div class="col-xs-8 col-sm-10 col-lg-11 col-md-11 w-90">Product Items Inventory</div>           
              </div>
            </div>
          </div> 
        </div>
      </div>
   
<!-- start container --> 
<div class="container">
    <div class="text-home">Invoice Plan</div>
      <section class="chat-plan-section">
          <div class="container">
            <div class="row chat-plan-list">
              @foreach ($plans as $plan)
              <div class="col-md-4" style="margin-top: 30px;">
                <div class="plan-box @if($plan->id==6) top-plan animation-css @endif">
                  <div class="plan-name"><span>Name</span> <span>{{ $plan->name }}</span></div>
                  <div class="plan-day"><span>Day</span>  <span><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $plan->access_day }} day</span> </div>
                  <div class="plan-message"><span>Invoices</span> <span><i class="fa fa-file" aria-hidden="true"></i> {{ $plan->invoices }}</span> </div>
                  <div class="plan-amount"><span>Amount</span> <span><i class="fa fa-inr" aria-hidden="true"></i> {{ $plan->amount }}</span> </div>
                  <a href="/buy-plan/{{ $plan->id }}" class="btn btn-style btn-top">Buy</a>
                </div>
              </div>
              @endforeach
            </div>
          </div>
    </section>
</div> 
<!-- end container -->  
@endsection