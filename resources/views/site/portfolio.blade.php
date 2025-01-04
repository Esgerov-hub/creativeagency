@extends('site.layouts.app')
@section('site.title')
    @lang('site.portfolio')
@endsection
@section('site.css')
@endsection
@section('site.content')
    <!-- banner -->
    <div class="mil-inner-banner">
        <div class="mil-banner-content mil-up">
            <div class="mil-animation-frame">
                <div class="mil-animation mil-position-4 mil-dark mil-scale" data-value-1="6" data-value-2="1.4"></div>
            </div>
            <div class="container">
                <ul class="mil-breadcrumbs mil-mb-60">
                    <li><a href="{{ route('site.index') }}">@lang('site.home')</a></li>
                    <li><a href="">@lang('site.portfolio')</a></li>
                </ul>
                <h1 class="mil-mb-60">@lang('site.our_portfolio')</h1>
                <a href="#portfolio" class="mil-link mil-dark mil-arrow-place mil-down-arrow">
                    <span></span>
                </a>
            </div>
        </div>
    </div>
    <!-- banner end -->

    <!-- portfolio -->
    <section id="portfolio">
        <div class="container mil-portfolio mil-p-120-60">

            <div class="mil-lines-place"></div>
            <div class="mil-lines-place mil-lines-long"></div>

            <div class="row justify-content-between align-items-center">
                @if(!empty($projects[0]))
                    @foreach($projects as $key => $project)
                            <?php $slug = !empty($project['slug'][$currentLang]) ? $project['slug'][$currentLang] : null;?>
                        @if($key == 0 || $key == count($projects) - 1 || ($key % 3) == 0)
                            <div class="col-lg-5">
                                <a href="{{ route('site.portfolioDetail',['slug' => $slug ]) }}" class="mil-portfolio-item mil-more mil-mb-60">
                                    <div class="mil-cover-frame mil-vert mil-up">
                                        <div class="mil-cover">
                                            <img src="{{ asset('uploads/useful/image/' . $project->image) }}" alt="cover">
                                        </div>
                                    </div>
                                    <div class="mil-descr">
                                        <div class="mil-labels mil-up mil-mb-15">
                                            <div class="mil-label mil-upper mil-accent">
                                                {!! !empty($project['category']['title'][$currentLang]) ? $project['category']['title'][$currentLang] : null !!}
                                            </div>
                                            <div class="mil-label mil-upper">{{ date('d-m-Y', strtotime($project->datetime)) }}</div>
                                        </div>
                                        <h4 class="mil-up">
                                            {!! !empty($project['title'][$currentLang]) ? $project['title'][$currentLang] : null !!}
                                        </h4>
                                    </div>
                                </a>
                            </div>
                        @else
                            <div class="col-lg-6">
                                <a href="{{ route('site.portfolioDetail',['slug' => $slug ]) }}" class="mil-portfolio-item mil-more mil-parallax mil-mb-60"
                                   data-value-1="60" data-value-2="-60">
                                    <div class="mil-cover-frame mil-hori mil-up">
                                        <div class="mil-cover">
                                            <img src="{{ asset('uploads/useful/image/' . $project->image) }}" alt="cover">
                                        </div>
                                    </div>
                                    <div class="mil-descr">
                                        <div class="mil-labels mil-up mil-mb-15">
                                            <div class="mil-label mil-upper mil-accent">
                                                {!! !empty($project['category']['title'][$currentLang]) ? $project['category']['title'][$currentLang] : null !!}
                                            </div>
                                            <div class="mil-label mil-upper">{{ date('d-m-Y', strtotime($project->datetime)) }}</div>
                                        </div>
                                        <h4 class="mil-up">
                                            {!! !empty($project['title'][$currentLang]) ? $project['title'][$currentLang] : null !!}
                                        </h4>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <!-- portfolio end -->
    <!-- call to action -->
    <section class="mil-soft-bg">
        <div class="container mil-p-120-120">
            <div class="mil-center">
                <h2 class="mil-up mil-mb-60"><span class="mil-thin">@lang('site.project_yes')</span></h2>
                <div class="mil-up">
                    <a href="{{ route('site.contact') }}"  class="mil-button mil-arrow-place"><span>@lang('site.contact_us')</span></a>
                </div>
            </div>
        </div>
    </section>
    <!-- call to action end -->


    <!-- content -->
@endsection
@section('site.js')
@endsection
