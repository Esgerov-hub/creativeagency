@extends('admin.layouts.app')
@section('admin.title')
    @lang('admin.complaint')
@endsection
@section('admin.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css">
@endsection
@section('admin.content')
    <div class="main-content">
        <div class="dashboard-breadcrumb mb-25">
            <h2>@lang('admin.complaint')</h2>
        </div>
        @include('components.admin.error')
        <div class="row">
            <div class="col-12">
                <form action=" @if(!empty($complaint['id'])) {{ route('admin.complaint.update',$complaint['id']) }} @else{{ route('admin.complaint.store') }}@endif" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(!empty($complaint['id']))
                        @method('PUT')
                    @endif
                    <div class="panel">
                        <div class="panel-body">
                            <ul class="nav nav-pills nav-justified" role="tablist">
                                @if(!empty($locales))
                                    @foreach($locales as $key => $lang)
                                        <li class="nav-item waves-effect waves-light">
                                            <a class="nav-link @if(++$key ==1) active @endif" data-bs-toggle="tab"
                                               href="#{{$lang->code}}" role="tab">
                                                <span class="d-none d-sm-block">{{ucfirst($lang->code)}}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-bs-toggle="tab"
                                       href="#contact" role="tab">
                                        <span class="d-none d-sm-block">@lang('admin.contact')</span>
                                    </a>
                                </li>
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-bs-toggle="tab"
                                       href="#logo" role="tab">
                                        <span class="d-none d-sm-block">@lang('admin.file')</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content p-3 text-muted">
                                @if(!empty($locales))
                                    @foreach($locales as $key => $lang)
                                        <div class="tab-pane @if(++$key ==1) active @endif" id="{{$lang['code']}}"
                                             role="tabpanel">
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label class="form-label">@lang('admin.title') - {{$lang['code']}}</label>
                                                    <input type="text" class="form-control" name="title[{{$lang['code']}}]" value="{{ !empty($complaint['title'][$lang['code']])? $complaint['title'][$lang['code']]: NULL }}">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">@lang('admin.text') - {{$lang['code']}}</label>
                                                    <textarea class="form-control" type="text" name="text[{{$lang['code']}}]" >{{ !empty($complaint['text'][$lang['code']])? $complaint['text'][$lang['code']]: NULL }}</textarea>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">@lang('admin.file_title') - {{$lang['code']}}</label>
                                                    <input class="form-control" type="text" name="file_title[{{$lang['code']}}]" value="{{ !empty($complaint['file']['file_title'][$lang['code']])? $complaint['file']['file_title'][$lang['code']]: NULL }}">
                                                </div>


                                                <div class="col-3">
                                                    <label class="form-label">@lang('admin.block') 1 - {{$lang['code']}}</label>
                                                    <input class="form-control" type="text" name="block_one[{{$lang['code']}}]" value="{{ !empty($complaint['block']['block_one'][$lang['code']])? $complaint['block']['block_one'][$lang['code']]: NULL }}">
                                                </div>
                                                <div class="col-3">
                                                    <label class="form-label">@lang('admin.block') - {{$lang['code']}}</label>
                                                    <input class="form-control" type="text" name="block_two[{{$lang['code']}}]" value="{{ !empty($complaint['block']['block_two'][$lang['code']])? $complaint['block']['block_two'][$lang['code']]: NULL }}">
                                                </div>
                                                <div class="col-3">
                                                    <label class="form-label">@lang('admin.block') 3 - {{$lang['code']}}</label>
                                                    <input class="form-control" type="text" name="block_tree[{{$lang['code']}}]" value="{{ !empty($complaint['block']['block_tree'][$lang['code']])? $complaint['block']['block_tree'][$lang['code']]: NULL }}">
                                                </div>
                                                <div class="col-3">
                                                    <label class="form-label">@lang('admin.block') 4 - {{$lang['code']}}</label>
                                                    <input class="form-control" type="text" name="block_four[{{$lang['code']}}]" value="{{ !empty($complaint['block']['block_four'][$lang['code']])? $complaint['block']['block_four'][$lang['code']]: NULL }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="tab-pane" id="contact" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-sm-12">
                                            <label class="form-label">@lang('admin.phone')</label>
                                            <input type="text" class="form-control" name="phone" value="{{ !empty($complaint['contact']['phone'])? $complaint['contact']['phone']: NULL }}">
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="form-label">@lang('admin.Email')</label>
                                            <input type="email" class="form-control" name="email" value="{{ !empty($complaint['contact']['email'])? $complaint['contact']['email']: NULL }}">
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="form-label">@lang('admin.website')</label>
                                            <input type="text" class="form-control" name="website" value="{{ !empty($complaint['contact']['website'])? $complaint['contact']['website']: NULL }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="logo" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label">@lang('admin.file')</label>
                                            <input type="file" class="form-control" name="file">
                                        </div>
                                        <div class="col-md-4">
                                            @if(!empty($complaint['file']['file']))
                                                <div class="part-icon">
                                                    <a href="{{ asset('uploads/complaint/'.$complaint['file']['file']) }}">Fayla bax</a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">@lang('admin.save')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('admin.js')
    <script src="{{ asset('summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('summernote/editor_summernote.js') }}"></script>
@endsection

