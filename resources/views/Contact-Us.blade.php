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
        <li class="nav-item nav-text">
          <a class="nav-link" href="/about-us">About US</a>
        </li>
        <li class="nav-item nav-text">
          <a class="nav-link" href="/Contact-Us">Contact Us</a>
        </li>
        <li class="nav-item nav-text">
          <a class="nav-link" href="/login">Login</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container" style="margin-top: 120px;">
  <div class="contact-heading">CONTACT US</div>
  <form action="/contact-us" method="post" class="contact-form">
          {{ csrf_field() }}
      <div class="row">
        <div class="col-md-4 col-sm-4 col-12">
          <div class="form-group">
                  <input type="text" class="form-control contact-input-filed {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"  placeholder="Name" required value="{{ old('name') }}">
                   @if ($errors->has('name'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('name') }}</strong>
                          </span>
                    @endif
          </div>
        </div>
        <div class="col-md-4 col-sm-4 col-12">
          <div class="form-group">
                  <input type="text" class="form-control contact-input-filed {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"  placeholder="Email" required value="{{ old('email') }}">
                   @if ($errors->has('email'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('email') }}</strong>
                          </span>
                    @endif
          </div>
        </div>
        <div class="col-md-4 col-sm-4 col-12">
          <div class="form-group">
                  <input type="number" class="form-control contact-input-filed" maxlength="10" minlength="10"  placeholder="Phone" required value="{{ old('phone') }}">
          </div>
        </div>
      </div>
              
      <div class="row">
        <div class="col-12 col-md-12">
           <div class="form-group">
              <textarea class="form-control contact-text-filed" rows="5"  name="message"  placeholder="Message" required></textarea>
          </div>
        </div>
      </div>
             
              <center>
                <button type="submit" class="btn btn-block btn-lg contact-sub-btn">Send</button>
              </center>
  </form>
</div>


@endsection