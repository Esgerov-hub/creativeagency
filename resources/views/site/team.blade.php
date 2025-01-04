@extends('site.layouts.app')
@section('site.title')
    @lang('site.home')
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
                    <li><a href="">@lang('site.teams')</a></li>
                </ul>
                <h1 class="mil-mb-60"> <span class="mil-thin">@lang('site.teams')</span></h1>
                <a href="#team" class="mil-link mil-dark mil-arrow-place mil-down-arrow">
                    <span></span>
                </a>
            </div>
        </div>
    </div>
    <!-- banner end -->

    <!-- team -->
    <section id="team">
        <div class="container mil-p-120-90">
            <div class="row">
                @foreach($leaderShip as $index => $data)
                <div class="col-sm-6 col-md-4 col-lg-3">

                    <div class="mil-team-card mil-up mil-mb-30">
                        <img src="{{ asset('uploads/institute/leadership/'.$data->image) }}" alt="Team member">
                        <div class="mil-description">
                            <div class="mil-secrc-text">
                                <h5 class="mil-muted mil-mb-5">
                                    {{ !empty($data['full_name'][$currentLang]) ? $data['full_name'][$currentLang] : null }}
                                </h5>
                                <p class="mil-link mil-light-soft mil-mb-10">
                                    {{ !empty($data['positionParent']['title'][$currentLang]) ? $data['positionParent']['title'][$currentLang] : \Illuminate\Support\Facades\Lang::get('admin.institute') }}
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- team end -->

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

@endsection
@section('site.js')

@endsection
