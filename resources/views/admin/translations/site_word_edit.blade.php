@extends('admin.layouts.app')
@section('admin.title')
    @lang('admin.admin_words')
@endsection
@section('admin.css')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/jquery.uploader.css') }}">
@endsection
@section('admin.content')
    <div class="main-content">
        @include('components.admin.error')
        <div class="row">
            <div class="col-12">
                <div class="panel">
                    <div class="panel-body">
                        <h4 class="panel-title-desc">{{ $translation['name'] }} - @lang('admin.site_words')</h4>
                        <form action="{{ route('admin.site-words.update',$translation['code']) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="mb-3 row">
                                @foreach($siteStatisticsData as $key => $data)
                                    <div class="col-md-3">
                                        <textarea class="form-control" type="text" name="{{$key}}" id="input">{!! !empty($data)? $data: old($key) !!}</textarea>
                                    </div>
                                @endforeach
                                <div class="col-md-3">
                                    <button class="btn btn-success" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('admin.js')
@endsection
