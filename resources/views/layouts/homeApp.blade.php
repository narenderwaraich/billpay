<!doctype html>
<html class="no-js" lang="">
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{config('app.name')}} @if(isset($title)){{$title}}@endif</title>
    <meta name="description" content="@if(isset($description)){{$description}}@endif">
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
    <script src="/public/jquery/jquery-3.2.1.min.js"></script>
    <script src="/public/jquery/jquery.cookie.js"></script>
</script>
</head>
<body>

@include('etc.homeNavbar')
@yield('content')

@include('etc.footer')

<script>
  $(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye-slash fa-eye");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
</script>
<script src="/public/js/popper.min.js"></script>        
<script src="/public/bootstrap/js/bootstrap.min.js"></script>
<script src="/public/js/custom.js"></script>
<script src="/public/js/toastr.min.js"></script>
{!! Toastr::message() !!}
    </body>
</html>  