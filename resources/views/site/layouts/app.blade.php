<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- bootstrap grid css -->
    <link rel="stylesheet" href="{{ asset('site/assets/css/plugins/bootstrap-grid.css') }}">
    <!-- font awesome css -->
    <link rel="stylesheet" href="{{ asset('site/assets/css/plugins/font-awesome.min.css') }}">
    <!-- swiper css -->
    <link rel="stylesheet" href="{{ asset('site/assets/css/plugins/swiper.min.css') }}">
    <!-- fancybox css -->
    <link rel="stylesheet" href="{{ asset('site/assets/css/plugins/fancybox.min.css') }}">
    <!-- ashley scss -->
    <link rel="stylesheet" href="{{ asset('site/assets/css/style.css') }}">
    <!-- page name -->
    <title>Creative Agency - @yield('site.title')</title>
    @yield('site.css')
</head>
<body>
<!-- wrapper -->
<div class="mil-wrapper" id="top">
    <!-- content -->
    <div class="mil-content">
        <div id="swupMain" class="mil-main-transition">
            <x-site.header />
            @yield('site.content')
            <!-- content -->
        </div>
    </div>
</div>
<!-- wrapper end -->
<x-site.footer />
