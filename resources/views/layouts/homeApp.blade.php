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
    <meta name="google-site-verification" content="NRgkBXOmKw9pm85YTPgV6tzPk4gqL-I1upSntx2UVVo" />
    <link rel="shortcut icon" href="/public/favicon.ico" type="image/x-icon">
    <link rel="canonical" href="http://www.freekafanda.in/" />
    <link rel="icon" href="/public/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="/css/themify-icons.css"> -->
    <link rel="stylesheet" href="/public/css/design.css">
    <link rel="stylesheet" href="/public/css/custom.css">
    <link rel="stylesheet" href="/public/css/responsive.css">
    <link rel="stylesheet" href="/public/css/toastr.min.css">
    <script src="/public/jquery/jquery-3.2.1.min.js"></script>
    <script src="/public/jquery/jquery.cookie.js"></script>
    <script data-ad-client="ca-pub-9262832715958252" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> 
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-160812913-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-160812913-1');
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