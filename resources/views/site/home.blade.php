@extends('site.layouts.app')
@section('site.title')
    @lang('site.home')
@endsection
@section('site.css')
@endsection
@section('site.content')
    <!-- banner -->
    <section class="mil-banner mil-dark-bg">
        <div class="mi-invert-fix">
            <div class="mil-animation-frame">
                <div class="mil-animation mil-position-1 mil-scale" data-value-1="7" data-value-2="1.6"></div>
                <div class="mil-animation mil-position-2 mil-scale" data-value-1="4" data-value-2="1"></div>
                <div class="mil-animation mil-position-3 mil-scale" data-value-1="1.2" data-value-2=".1"></div>
            </div>

            <div class="mil-gradient"></div>

            <div class="container">
                <div class="mil-banner-content mil-up">
                    <h1 class="mil-muted mil-mb-60"> {!! !empty($slider['title'][$currentLang]) ? $slider['title'][$currentLang] : null !!}</h1>
                    <div class="row">
                        <div class="col-md-7 col-lg-5">
                            <p class="mil-light-soft mil-mb-60">{!! !empty($slider['text'][$currentLang])? $slider['text'][$currentLang]: null !!}</p>
                        </div>
                    </div>
                    <a href="{{ route('site.contact') }}" class="mil-button mil-arrow-place mil-btn-space">
                        <span>@lang('site.contact')</span>
                    </a>
                    <a href="{{ route('site.portfolio') }}" class="mil-link mil-muted mil-arrow-place">
                        <span>@lang('site.portfolio')</span>
                    </a>

                    <div class="mil-circle-text">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             x="0px" y="0px" viewBox="0 0 300 300" enable-background="new 0 0 300 300"
                             xml:space="preserve" class="mil-ct-svg mil-rotate" data-value="360">
                            <defs>
                                <path id="circlePath" d="M 150, 150 m -60, 0 a 60,60 0 0,1 120,0 a 60,60 0 0,1 -120,0 "/>
                            </defs>
                            <circle cx="150" cy="100" r="75" fill="none"/>
                            <g>
                                <use xlink:href="#circlePath" fill="none"/>
                                <text style="letter-spacing: 6.5px">
                                    <textPath xlink:href="#circlePath"></textPath>
                                </text>
                            </g>
                        </svg>
                        <a href="#about" class="mil-button mil-arrow-place mil-icon-button mil-arrow-down"></a>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- banner end -->

    <!-- about -->
    <section id="about">
        <div class="container mil-p-120-30">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-6 col-xl-5">
                    <div class="mil-mb-90">
                        <h2 class="mil-up mil-mb-60">Creative <br>Agency <span class="mil-thin">Studio</span></h2>
                        <p class="mil-up mil-mb-30">{!! !empty($about['text'][$currentLang])? $about['text'][$currentLang]: NULL  !!}</p>
                        <div class="mil-about-quote">
                            <a href="{{ route('site.about') }}" class="mil-button mil-arrow-place mil-btn-space">
                                <span>@lang('site.more')</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="mil-about-photo mil-mb-90">
                        <div class="mil-lines-place"></div>
                        <div class="mil-up mil-img-frame" style="padding-bottom: 160%;">
                            <img src="{{ asset('uploads/institute/abouts/'.$about['slider_image'][0]) }}" alt="img" class="mil-scale" data-value-1="1" data-value-2="1.2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- about end -->

    <!-- services -->
    <section class="mil-dark-bg">
        <div class="mi-invert-fix">
            <div class="mil-animation-frame">
                <div class="mil-animation mil-position-1 mil-scale" data-value-1="2.4" data-value-2="1.4" style="top: 300px; right: -100px"></div>
                <div class="mil-animation mil-position-2 mil-scale" data-value-1="2" data-value-2="1" style="left: 150px"></div>
            </div>
            <div class="container mil-p-120-0">

                <div class="mil-mb-120">
                    <div class="mil-complex-text justify-content-center mil-up mil-mb-15">
                        <span class="mil-text-image"><img src="{{ asset('site/assets/img/photo/2.jpg') }}" alt="team"></span>
                        <h2 class="mil-h1 mil-muted mil-center">@lang('site.service_title')</h2>
                    </div>
                    <div class="mil-complex-text justify-content-center mil-up">
                        <h2 class="mil-h1 mil-muted mil-center"><span class="mil-thin">@lang('site.service_content')</span></h2>
                    </div>
                </div>

                <div class="row mil-services-grid m-0">
                    @if(!empty($services))
                        @foreach($services as $service)
                            <div class="col-md-5 col-lg-3 mil-services-grid-item p-0">
                                <a href="{{ route('site.service',$service['slug'][$currentLang]) }}" class="mil-service-card-sm mil-up">
                                    <h5 class="mil-muted mil-mb-30">{{ !empty($service['title'][$currentLang])? $service['title'][$currentLang]: null }}</h5>
                                    <p class="mil-light-soft mil-mb-30">{!! !empty($service['text'][$currentLang])? $service['text'][$currentLang]: null !!}</p>
                                    <div class="mil-button mil-icon-button-sm mil-arrow-place"></div>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- services end -->

    <!-- team -->
    <section>
        <div class="container mil-p-120-30">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-5 col-xl-4">

                    <div class="mil-mb-90">
                        <h2 class="mil-up mil-mb-60">@lang('site.our_team')</h2>
                        <p class="mil-up mil-mb-30">@lang('site.our_team_content')</p>

                        <div class="mil-up">
                            <a href="{{ route('site.team') }}" class="mil-button mil-arrow-place mil-mb-60"><span>@lang('site.more')</span></a>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="mil-team-list">
                        <div class="mil-lines-place"></div>
                        <div class="row mil-mb-60">
                            <div class="col-sm-6">
                                @foreach($leaderShip as $index => $data)
                                    <div class="mil-team-card mil-up mil-mb-30">
                                        <img src="{{ asset('uploads/institute/leadership/'.$data->image) }}" alt="Team member">
                                        <div class="mil-description">
                                            <div class="mil-secrc-text">
                                                <h5 class="mil-muted mil-mb-5">
                                                    {{ !empty($data['full_name'][$currentLang]) ? $data['full_name'][$currentLang] : null }}
                                                </h5>
                                                <p class="mil-link mil-light-soft mil-mb-10">
                                                    {{ !empty($data['parent']['title'][$currentLang]) ? $data['parent']['title'][$currentLang] : \Illuminate\Support\Facades\Lang::get('admin.institute') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    @if($loop->iteration == ceil(count($leaderShip) / 2))
                            </div>
                            <div class="col-sm-6">
                                <p class="mil-mobile-hidden mil-text-sm mil-mb-30" style="height: 30px;">
                                    <span class="mil-accent"></span>
                                </p>
                                @endif
                                @endforeach
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- team end -->

    <!-- reviews -->
    <section class="mil-soft-bg">
        <div class="container mil-p-120-120">
            <h2 class="mil-center mil-up mil-mb-60">@lang('site.our_customer')</h2>
            <div class="mil-revi-pagination mil-up mil-mb-60"></div>
        </div>
    </section>
    <!-- reviews end -->

    <!-- partners -->
    <div class="mil-soft-bg">
        <div class="container mil-p-0-120">

            <div class="swiper-container mil-infinite-show mil-up">
                <div class="swiper-wrapper">
                    @if(!empty($usefulLink[0]))
                        @foreach($usefulLink as $link)
                            <div class="swiper-slide">
                                <a href="{{$link->link}}" class="mil-partner-frame" style="width: 100px;">
                                    <img src="{{ asset('uploads/usefulLink/'.$link->image) }}" alt="{{ !empty($link['title'][$currentLang])? $link['title'][$currentLang]: null }}" />
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>
    </div>
    <!-- partners end -->

    <!-- blog -->
    <section>
        <div class="container mil-p-120-60">
            <div class="row align-items-center mil-mb-30">
                <div class="col-lg-6 mil-mb-30">
                    <h3 class="mil-up">@lang('site.last_news')</h3>
                </div>
                <div class="col-lg-6 mil-mb-30">
                    <div class="mil-adaptive-right mil-up">
                        <a href="{{ route('site.news') }}" class="mil-link mil-dark mil-arrow-place">
                            <span>@lang('site.all_view')</span>
                        </a>
                    </div>
                </div>
            </div>
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
    <!-- blog end -->
@endsection
@section('site.js')

@endsection
