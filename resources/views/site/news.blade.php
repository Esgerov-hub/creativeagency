@extends('site.layouts.app')
@section('site.title')
    @lang('site.news')
@endsection
@section('site.css')
@endsection
@section('site.content')
    <!-- banner -->
    <div class="mil-inner-banner mil-p-0-120">
        <div class="mil-banner-content mil-up">
            <div class="mil-animation-frame">
                <div class="mil-animation mil-position-4 mil-dark mil-scale" data-value-1="6" data-value-2="1.4"></div>
            </div>
            <div class="container">
                <ul class="mil-breadcrumbs mil-mb-60">
                    <li><a href="{{ route('site.index') }}">@lang('site.home')</a></li>
                    <li><a href="">@lang('site.news')</a></li>
                </ul>
                <h1 class="mil-mb-60">@lang('site.last_news')</h1>
                <a href="#blog" class="mil-link mil-dark mil-arrow-place mil-down-arrow">
                    <span></span>
                </a>
            </div>
        </div>
    </div>
    <!-- banner end -->

    <!-- popular -->
    <section class="mil-soft-bg" id="blog">
        <div class="container mil-p-120-60">
            <div class="row">
                @if(!empty($news[0]))
                    @foreach($news as $newKey=>$newItem)
                            <?php $slug = !empty($newItem['slug'][$currentLang]) ? $newItem['slug'][$currentLang] : null;?>
                        <div class="col-lg-6">
                            <a href="{{ route('site.newsDetail',['slug' => $slug ]) }}" class="mil-blog-card mil-mb-60">
                                <div class="mil-cover-frame mil-up">
                                    <img src="{{ asset('uploads/news/'.$newItem->image) }}" alt="{!! !empty($newItem['title'][$currentLang])? $newItem['title'][$currentLang]: null !!}" />
                                </div>
                                <div class="mil-post-descr">
                                    <div class="mil-labels mil-up mil-mb-30">
                                        <div class="mil-label mil-upper mil-accent">TECHNOLOGY</div>
                                        <div class="mil-label mil-upper">{{ date('d-m-Y H:i', strtotime($newItem->datetime)) }}</div>
                                    </div>
                                    <h4 class="mil-up mil-mb-30">{!! !empty($newItem['title'][$currentLang])? $newItem['title'][$currentLang]: null !!}</h4>
                                    <p class="mil-post-text mil-up mil-mb-30">{!! !empty($newItem['text'][$currentLang])? substr($newItem['text'][$currentLang], 0, 200).'...': null !!}</p>
                                    <div class="mil-link mil-dark mil-arrow-place mil-up">
                                        <span>@lang('site.more')</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <!-- popular end -->

@endsection
@section('site.js')
@endsection
