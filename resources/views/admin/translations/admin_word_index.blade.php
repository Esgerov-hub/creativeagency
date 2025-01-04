@extends('admin.layouts.app')
@section('admin.title')
    @lang('admin.admin_words')
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
                            <h5>@lang('admin.admin_words')</h5>
                            <div class="btn-box d-flex flex-wrap gap-2">
                                <div id="tableSearch"></div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-dashed table-hover digi-dataTable task-table table-striped" id="taskTable">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('admin.lang')</th>
                                    <th>@lang('admin.edit')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($translations as $data)
                                    <tr>
                                        <td>{{ $data['id'] }}</td>
                                        <td>{{ $data['name'] }} - @lang('admin.admin_words')</td>
                                        <td>
                                            <a  class="btn btn-sm btn-icon btn-primary" href="{{ route('admin.admin-words.edit', $data['code']) }}">
                                                <span class="text-500 fas fa-edit"></span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
    </div>
    <!-- End Page-content -->
@endsection
@section('admin.js')
@endsection
