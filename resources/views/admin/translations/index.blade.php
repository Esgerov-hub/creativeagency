@extends('admin.layouts.app')
@section('admin.title')
    @lang('admin.translations')
@endsection
@section('admin.css')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/jquery.uploader.css') }}">
@endsection
@section('admin.content')
    <div class="main-content">
        <div class="dashboard-breadcrumb mb-25">
            <h2>@lang('admin.translations')</h2>
        </div>
        @include('components.admin.error')
        <div class="row g-4">
            <div class="col-xxl-4 col-md-5">
                <div class="panel">
                    <div class="panel-header">
                        <h5>@lang('admin.add')</h5>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('admin.translations.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">@lang('admin.lang')</label>
                                    <input type="text" class="form-control" name="name">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">@lang('admin.code')</label>
                                    <input type="text" class="form-control" name="code">
                                </div>
                                <div class="col-sm-12">
                                    <label class="form-label">@lang('admin.icon')</label>
                                    <input type="file" class="form-control" name="image">
                                </div>
                                <div class="col-sm-12">
                                    <label class="form-label">@lang('admin.status')</label>
                                    <select class="form-control" name="status">
                                        <option value="1" >Aktiv</option>
                                        <option value="0" >Deactiv</option>
                                    </select>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <div class="btn-box">
                                        <button class="btn btn-primary w-100 login-btn">@lang('admin.save')</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xxl-8 col-md-7">
                <div class="panel">
                    <div class="panel-body">
                        <table class="table table-dashed table-hover digi-dataTable all-product-table table-striped" id="allProductTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('admin.code')</th>
                                <th>@lang('admin.lang')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($translations[0]) && isset($translations[0]))
                                @foreach($translations as $key => $value)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>{!! $value['name'] !!}</td>
                                        <td>
                                            <div class="table-category-card">
                                                @if(!empty($value['image']))
                                                <div class="part-icon">
                                                     <span>
                                                         <img src="{{ asset('uploads/translations/'.$value['image']) }}">
                                                     </span>
                                                </div>
                                                @endif
                                                <div class="part-txt">
                                                    <span class="category-name">{!! ucfirst($value['code']) !!}</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <div class="table-bottom-control"></div>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('admin.js')
    <script src="{{ asset('admin/assets/vendor/js/jquery.uploader.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/category.js') }}"></script>
@endsection
