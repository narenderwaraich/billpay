<!doctype html>
<html class="no-js" lang="">
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Online Bill Pay</title>
    <meta name="description" content="Online Bill Pay">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" type="text/css" href="/css/app.css">
  <!--   <link rel="apple-touch-icon" href="apple-icon.png"> -->
   <!--  <link rel="shortcut icon" href="favicon.ico"> -->
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="/css/themify-icons.css"> -->
    <link rel="stylesheet" href="/css/design.css">
    <link rel="stylesheet" href="/css/custom.css">
    <link rel="stylesheet" href="/css/responsive.css">
    <link rel="stylesheet" href="/css/toastr.min.css">
    <script src="/jquery/jquery-3.2.1.min.js"></script>
</script>
</head>
<body>


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
<script src="/js/popper.min.js"></script>        
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script src="/js/custom.js"></script>
<script src="/js/toastr.min.js"></script>
{!! Toastr::message() !!}
    </body>
</html>  