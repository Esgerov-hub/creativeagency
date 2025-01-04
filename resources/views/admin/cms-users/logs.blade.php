@extends('admin.layouts.app')
@section('admin.title')
    @lang('admin.logs')
@endsection
@section('admin.css')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/jquery.uploader.css') }}">
@endsection
@section('admin.content')
    <!-- main content start -->
    <div class="main-content">
        @include('components.admin.error')
        <div class="row">
            <div class="col-12">
                <div class="panel">
                    <div class="panel-header">
                        <h5>@lang('admin.logs')</h5>
                        <div class="btn-box d-flex flex-wrap gap-2">
                            <div id="tableSearch"></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-dashed table-hover digi-dataTable task-table table-striped" id="taskTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('admin.full_name')</th>
                                <th>@lang('admin.subj')</th>
                                <th>@lang('admin.note')</th>
                                <th>@lang('admin.ip_address')</th>
                                <th>@lang('admin.datetime')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($logs[0]) && isset($logs[0]))
                                @foreach($logs as $data)
                                    <tr>
                                        <td>{{ $data['id'] }}</td>
                                        <td>
                                            <div class="table-category-card">
                                                <div class="part-txt">
                                                    <span
                                                        class="category-name">{!! $data->cms_user['name'] !!} {!! $data->cms_user['surname'] !!} {!! $data->cms_user['father_name'] !!}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{!! $data['subj_id'] !!}#{!! $data['subj_table'] !!}</td>
                                        <td>{!! $data['description'] !!}</td>
                                        <td>{!! $data['ip_address'] !!}</td>
                                        <td>{!! $data['datetime'] !!}</td>
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
    </div>
@endsection

@section('admin.js')
    <script src="{{ asset('admin/assets/vendor/js/jquery.uploader.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/category.js') }}"></script>
@endsection

