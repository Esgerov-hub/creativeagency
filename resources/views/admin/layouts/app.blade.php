<!DOCTYPE html>
<html lang="en" data-menu="vertical" data-nav-size="nav-default">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creative Agency -@yield('admin.title')</title>

    <link rel="shortcut icon" href="{{ asset('admin/avatar/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/jquery.uploader.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{  asset('admin/assets/vendor/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <link rel="stylesheet" id="primaryColor" href="{{ asset('admin/assets/css/blue-color.css') }}">
    <link rel="stylesheet" id="rtlStyle" href="#">
    @yield('admin.css')
</head>
<body class="body-padding body-p-top light-theme">
<!-- preloader start -->
<div class="preloader d-none">
    <div class="loader">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
<!-- preloader end -->

<!-- header start -->
<x-admin.header />

<!-- main sidebar start -->
<x-admin.main />
<!-- main sidebar end -->

<!-- main content start -->
@yield('admin.content')
<!-- main content end -->
<x-admin.footer />

