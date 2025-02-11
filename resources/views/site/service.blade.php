@extends('site.layouts.app')
@section('site.title')
    {{ !empty($service['title'][$currentLang]) ? $service['title'][$currentLang]: '' }}
@endsection
@section('site.css')
@endsection
@section('site.content')
    <!-- banner -->
    <div class="mil-inner-banner">
        <div class="mil-banner-content mil-center mil-up">
            <div class="container">
                <ul class="mil-breadcrumbs mil-center mil-mb-60">
                    <li><a href="{{ route('site.index') }}">@lang('site.home')</a></li>
                    <li><a href="">{{ !empty($service['title'][$currentLang]) ? $service['title'][$currentLang]: '' }}</a></li>
                </ul>
                <h2><span class="mil-thin">{!! !empty($service['title'][$currentLang])? $service['title'][$currentLang]: null !!}</span></h2>
            </div>
        </div>
    </div>
    <!-- publication -->
    <section id="blog">
        <div class="container mil-p-120-90">
            <div class="row justify-content-center">

                <div class="col-lg-16">
                  {{--  <p class="mil-text-xl mil-dark mil-up mil-mb-60"> --}}{!! !empty($service['text'][$currentLang])? $service['text'][$currentLang]: NULL  !!}{{--</p>--}}
                    <div class="row">
                        <div class="swiper-container news-slider">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="mil-image-frame mil-horizontal mil-up mil-mb-30">
                                        <img src="{{ asset('uploads/services/'.$service->image) }}" alt="Publication cover">
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('site.js')

@endsection
