@extends('admin.layouts.app')
@section('admin.title')
    @lang('admin.settings')
@endsection
@section('admin.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css">
@endsection
@section('admin.content')
    <div class="main-content">
        <div class="dashboard-breadcrumb mb-25">
            <h2>@lang('admin.settings')</h2>
        </div>
        @include('components.admin.error')
        <div class="row">
            <div class="col-12">
                <form action="@if(!empty($setting['id'])) {{ route('admin.settings.update',$setting['id']) }} @else{{ route('admin.settings.store') }}@endif" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(!empty($setting['id']))
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
                                        <span class="d-none d-sm-block">@lang('admin.logo')</span>
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
                                                    <input type="text" class="form-control" name="title[{{$lang['code']}}]" value="{{ !empty($setting['title'][$lang['code']])? $setting['title'][$lang['code']]: NULL }}">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">@lang('admin.text') - {{$lang['code']}}</label>
                                                    <textarea class="form-control" type="text" name="text[{{$lang['code']}}]" >{{ !empty($setting['text'][$lang['code']])? $setting['text'][$lang['code']]: NULL }}</textarea>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">@lang('admin.address') - {{$lang['code']}}</label>
                                                    <input class="form-control" type="text" name="address[{{$lang['code']}}]" value="{{ !empty($setting['address'][$lang['code']])? $setting['address'][$lang['code']]: NULL }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="tab-pane" id="contact" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-sm-12">
                                            <label class="form-label">@lang('admin.phone')</label>
                                            <input type="text" class="form-control" name="phone" value="{{ !empty($setting['phone'])? $setting['phone']: NULL }}">
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="form-label">@lang('admin.Email')</label>
                                            <input type="email" class="form-control" name="email" value="{{ !empty($setting['email'])? $setting['email']: NULL }}">
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="form-label">Instagram</label>
                                            <input type="text" class="form-control" name="instagram" value="{{ !empty($setting['instagram'])? $setting['instagram']: NULL }}">
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="form-label">Telegram</label>
                                            <input type="text" class="form-control" name="telegram" value="{{ !empty($setting['telegram'])? $setting['telegram']: NULL }}">
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="form-label">Whatsapp</label>
                                            <input type="text" class="form-control" name="whatsapp" value="{{ !empty($setting['whatsapp'])? $setting['whatsapp']: NULL }}">
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="form-label">Youtube</label>
                                            <input type="text" class="form-control" name="youtube" value="{{ !empty($setting['youtube'])? $setting['youtube']: NULL }}">
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="form-label">Linkedin</label>
                                            <input type="text" class="form-control" name="linkedin" value="{{ !empty($setting['linkedin'])? $setting['linkedin']: NULL }}">
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="form-label">Facebook</label>
                                            <input type="text" class="form-control" name="facebook" value="{{ !empty($setting['facebook'])? $setting['facebook']: NULL }}">
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="form-label">Twitter</label>
                                            <input type="text" class="form-control" name="twitter" value="{{ !empty($setting['twitter'])? $setting['twitter']: NULL }}">
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="form-label">accepted_samples</label>
                                            <input type="number" class="form-control" name="accepted_samples" value="{{ !empty($setting['accepted_samples'])? $setting['accepted_samples']: 0 }}">
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="form-label">laboratory_examinations</label>
                                            <input type="number" class="form-control" name="laboratory_examinations" value="{{ !empty($setting['laboratory_examinations'])? $setting['laboratory_examinations']: 0 }}">
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="form-label">animal_identification</label>
                                            <input type="number" class="form-control" name="animal_identification" value="{{ !empty($setting['animal_identification'])? $setting['animal_identification']: 0 }}">
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="form-label">trainees</label>
                                            <input type="number" class="form-control" name="trainees" value="{{ !empty($setting['trainees'])? $setting['trainees']: 0 }}">
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane" id="logo" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label">@lang('admin.header_logo')</label>
                                            <input type="file" class="form-control" name="header_logo">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">@lang('admin.footer_logo')</label>
                                            <input type="file" class="form-control" name="footer_logo">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">@lang('admin.favicon')</label>
                                            <input type="file" class="form-control" name="favicon">
                                        </div>
                                        <div class="col-md-4">
                                            @if(!empty($setting['header_logo']))
                                                <div class="part-icon">
                                                    <span><img src="{{ asset('uploads/settings/'.$setting['header_logo']) }}" style="background-color: black;"></span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            @if(!empty($setting['footer_logo']))
                                                <div class="part-icon">
                                                    <span><img src="{{ asset('uploads/settings/'.$setting['footer_logo']) }}"></span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-3">
                                            @if(!empty($setting['favicon']))
                                                <div class="part-icon">
                                                    <span><img src="{{ asset('uploads/settings/'.$setting['favicon']) }}" style="background-color: black;"></span>
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

