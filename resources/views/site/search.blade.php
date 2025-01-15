@extends('site.layouts.app')
@section('site.title')
   @lang('site.search')
@endsection
@section('site.css')
    <link rel="stylesheet" href="{{ asset("site/assets/css/search_result.css") }}" />
@endsection
@section('site.content')
    <section class="search_result">
        @if(!empty($results[0]))
            <h1>@lang('site.search')</h1>
            <div class="results">
                    @foreach($results as $key=>$data)
                        <a  href="{{$data['link']}}" target="_blank" class="search_result_div">
                            <h5>
                                @if(!empty($data['category']))
                                {!! $data['category'] !!}
                                @elseif(!empty($data['title'][$currentLang]))
                                    {!! $data['title'][$currentLang] !!}
                                @endif
                            </h5>
                            <div class="text_result">
                                Sıra №-si <span class="highlight">{{++$key}}</span> -
                                @if(!empty($data['title'][$currentLang]))
                                    {!! $data['title'][$currentLang] !!}
                                @elseif(!empty($data['text'][$currentLang]))
                                    {!! $data['text'][$currentLang] !!}
                                @endif
                            </div>
                            @if(!empty($data->datetime) && date('Y', strtotime($data->datetime)) > 1970)
                            <span>{{ date('d-m-Y', strtotime($data->datetime)) }}</span> <span>{{ date('H:i', strtotime($data->datetime)) }}</span>
                            @endif
                        </a>
                    @endforeach
            </div>
        @else
            <h1>@lang('site.not_search_content')</h1>
        @endif
    </section>
@endsection
@section('site.js')
    <script src="{{ asset("site/assets/js/search_result.js") }}"></script>
@endsection
