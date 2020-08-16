@extends('layouts.homeApp')
@section('content')
<nav class="navbar navbar-expand-lg navbar-dark static-top">
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
          <a class="nav-link" href="/about-us">About US</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/Contact-Us">Contact Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/login">Login</a>
        </li>
      </ul>
    </div>
  </div>
</nav>




@endsection