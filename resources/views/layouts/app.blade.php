<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Online Bill Pay</title>
    <meta name="description" content="Online Bill Pay">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" type="text/css" href="/public/css/app.css">
  <!--   <link rel="apple-touch-icon" href="apple-icon.png"> -->
   <!--  <link rel="shortcut icon" href="favicon.ico"> -->
    <link rel="stylesheet" href="/public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="/css/themify-icons.css"> -->
    <link rel="stylesheet" href="/public/css/design.css">
    <link rel="stylesheet" href="/public/css/custom.css">
    <link rel="stylesheet" href="/public/css/responsive.css">
    <link rel="stylesheet" href="/public/css/toastr.min.css">
    <link rel="stylesheet" href="/public/css/jquery.auto-complete.css">
    <link rel="stylesheet" href="/public/bootstrap/css/bootstrap-toggle.min.css">
    <script src="/public/jquery/jquery-3.2.1.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.11/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.11/css/gijgo.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="wrapper ">
  <div class="main-panel" id="main-panel">
    @include('etc.navbar')
    @include('etc.message')

    @yield('content')
    @if(!empty(Auth::user()->avatar))

    @else
    <style type="text/css">
    #profileImage {
              background: #1e2027;
              color: #fff;
              border-radius: 50%;
              font-size: 32px;
              padding: 10px;
              text-align: center;
              text-transform: uppercase;
              border: 2px solid #df59f9;
              display: inline-block;
            }
    </style>

    @endif
  </div>
</div>
<script src="/public/bootstrap/js/popper.min.js"></script>
<script src="/public/bootstrap/js/bootstrap.min.js"></script>
<script src="/public/bootstrap/js/bootstrap-toggle.min.js"></script>
<script src="/public/js/custom.js"></script>
<script src="/public/js/toastr.min.js"></script>
{!! Toastr::message() !!}
    </body>
</html>  