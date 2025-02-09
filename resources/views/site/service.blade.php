@extends('site.layouts.app')
@section('site.title')
    {{ !empty($service['title'][$currentLang]) ? $service['title'][$currentLang]: '' }}
@endsection
@section('site.css')
@endsection
@section('site.content')
    <!-- banner -->
    <div class="mil-inner-banner">
        <div class="mil-animation-frame">
            <div class="mil-animation mil-position-4 mil-dark mil-scale" data-value-1="6" data-value-2="1.4"></div>
        </div>
        <div class="mil-banner-content mil-up">
            <div class="container">
                <ul class="mil-breadcrumbs mil-mb-60">
                    <li><a href="{{ route('site.index') }}">@lang('site.home')</a></li>
                    <li><a href="">{{ !empty($service['title'][$currentLang]) ? $service['title'][$currentLang]: '' }}</a></li>
                </ul>
                <h1 class="mil-mb-60">{{ !empty($service['title'][$currentLang]) ? $service['title'][$currentLang]: '' }}</h1>
                <a href="#service" class="mil-link mil-dark mil-arrow-place mil-down-arrow">
                    <span></span>
                </a>
            </div>
        </div>
    </div>
    <!-- banner end -->
    <!-- about -->
    <section id="about">
        <div class="container mil-p-120-30">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-6 col-xl-5">
                    <div class="mil-mb-90">
                        {!! !empty($service['text'][$currentLang])? $service['text'][$currentLang]: NULL  !!}
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="mil-about-photo mil-mb-90">
                        <div class="mil-lines-place"></div>
                        <div class="mil-up mil-img-frame" style="padding-bottom: 160%;">
                            <img src="{{ asset('uploads/services/'.$service->image) }}" alt="img" class="mil-scale" data-value-1="1" data-value-2="1.2">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- about end -->
@endsection
@section('site.js')

@endsection
