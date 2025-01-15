@extends('site.layouts.app')
@section('site.title')
    @lang('site.not_page')
@endsection
@section('site.css')
    <link rel="stylesheet" href="{{ asset("site/assets/css/not_found.css") }}" />
@endsection
@section('site.content')
    <section>
        <h1>Məlumat tapılmadı.</h1>
    </section>
@endsection
@section('site.js')
@endsection
