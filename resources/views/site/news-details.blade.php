@extends('site.layouts.app')
@section('site.title')
@endsection
@section('site.css')
    <!-- Swiper CSS -->

@endsection
@section('site.content')
    <!-- banner -->
    <div class="mil-inner-banner">
        <div class="mil-banner-content mil-center mil-up">
            <div class="container">
                <ul class="mil-breadcrumbs mil-center mil-mb-60">
                    <li><a href="{{ route('site.index') }}">@lang('site.home')</a></li>
                    <li><a href="{{ route('site.news') }}">@lang('site.news')</a></li>
                    <li><a href="">{!! !empty($news['title'][$currentLang])? Str::limit($news['title'][$currentLang], 50): null !!}...</a></li>
                </ul>
                <h2><span class="mil-thin">{!! !empty($news['title'][$currentLang])? $news['title'][$currentLang]: null !!}</span></h2>
            </div>
        </div>
    </div>
    <!-- banner end -->

    <!-- publication -->
    <section id="blog">
        <div class="container mil-p-120-90">
            <div class="row justify-content-center">
                <div class="col-lg-12">

                    <div class="mil-image-frame mil-horizontal mil-up">
                        <img src="{{ asset('uploads/news/'.$news->image) }}" alt="Publication cover" class="mil-scale" data-value-1=".90" data-value-2="1.15">
                    </div>
                    <div class="mil-info mil-up mil-mb-90">
                        <div>&nbsp;<span class="mil-dark">{{ date('d-m-Y H:i', strtotime($news->datetime)) }}</span></div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <p class="mil-text-xl mil-dark mil-up mil-mb-60">{!! !empty($news['fulltext'][$currentLang])? $news['fulltext'][$currentLang]: null !!}</p>
                    @if(!empty($news['slider_image'][0]))
                        <div class="row">
                            <div class="swiper-container news-slider">
                                <div class="swiper-wrapper">
                                    @foreach($news['slider_image'] as $slider_image)
                                        <div class="swiper-slide">
                                            <div class="mil-image-frame mil-horizontal mil-up mil-mb-30">
                                                <img src="{{ asset('uploads/news/slider_image/'.$slider_image) }}" alt="Publication cover">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- publication end -->
@endsection
@section('site.js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var swiper = new Swiper('.swiper-container', {
                loop: true,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
            });
        });
    </script>
@endsection
