<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bill Book Admin Panel</title>
    <meta name="description" content="Bill Book">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" type="text/css" href="/public/css/app.css">
    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="/public/css/normalize.css">
    <link rel="stylesheet" href="/public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/font-awesome.min.css">
    <link rel="stylesheet" href="/public/css/themify-icons.css">
    <link rel="stylesheet" href="/public/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="/public/css/admin-custom.css">
    <link rel="stylesheet" href="/public/css/toastr.min.css">
    <script src="/public/jquery/jquery-3.2.1.min.js"></script>
</head>
<body>

@include('etc.Admin_navbar')
@include('etc.message')


@yield('content')

    <script src="/public/bootstrap/js/popper.min.js"></script>
    <!-- <script src="/bootstrap/js/bootstrap.min.js"></script> -->
    <script src="/public/js/plugins.js"></script>
    <script src="/public/js/main.js"></script>
    <script src="/public/js/admin-custom.js"></script>
    <script src="/public/js/toastr.min.js"></script>
    {!! Toastr::message() !!}
</body>  
</html>  