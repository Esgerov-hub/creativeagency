@extends('site.layouts.app')
@section('site.title')
    @lang('site.not_page')
@endsection
@section('site.css')
    <link rel="stylesheet" href="{{ asset("site/assets/css/404.css") }}" />
@endsection
@section('site.content')
    <section class="not_found">
        <div class="not_found_img">
            <img src="{{ asset('site/assets/images/404.png') }}" alt="404" />
        </div>
        <div class="not_found_text">@lang('site.not_page')</div>
        <a href="{{ url()->previous() }}">@lang('site.go_back')</a>
    </section>
@endsection
@section('site.js')
@endsection
