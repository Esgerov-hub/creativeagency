@extends('admin.layouts.app')
@section('admin.title')
    @lang('admin.roles')
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
                        <h5>@lang('admin.roles')</h5>
                        <div class="btn-box d-flex flex-wrap gap-2">
                            <div id="tableSearch"></div>
                            @can('roles-create')
                            <a href="{{ route('admin.roles.create') }}"  class="btn btn-sm btn-primary" >
                                <i class="fa-light fa-plus"></i> @lang('admin.add')
                            </a>
                            @endcan
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-dashed table-hover digi-dataTable task-table table-striped" id="taskTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('admin.roles')</th>
                                <th>@lang('admin.settings')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($roles[0]) && isset($roles[0]))
                                @foreach($roles as $data)
                                    @if($data['id'] !=1)
                                    <tr>
                                        <td>{{ $data['id'] }}</td>
                                        <td>{!! $data['name'] !!}</td>
                                        <td>
                                            <div class="btn-box">
                                                @can('roles-edit')
                                                <a href="{{ route('admin.roles.edit',$data['id']) }}" class="btn btn-sm btn-icon btn-primary" title="@lang('admin.edit')"><i
                                                        class="fa-light fa-edit"></i>
                                                </a>
                                                @endcan
                                                @can('roles-delete')
                                                <button class="btn btn-sm btn-icon btn-danger" data-bs-toggle="modal" data-bs-target="#deletecategory{{$data['id']}}" title="@lang('admin.delete')">
                                                    <i class="fa-light fa-trash-can"></i>
                                                </button>
                                                @endcan
                                            </div>
                                            @endif
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
    </div>
    <!-- main content end -->
    @if(!empty($roles[0]) && isset($roles[0]))
        @foreach($roles as $value)
            <div class="modal fade" id="deletecategory{{$value['id']}}" tabindex="-1"
                 aria-labelledby="deletecategory{{$value['id']}}Label" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title" id="deletecategory{{$value['id']}}Label">@lang('admin.delete')</h2>
                            <button type="button" class="btn btn-sm btn-icon btn-outline-primary"
                                    data-bs-dismiss="modal" aria-label="Close"><i class="fa-light fa-times"></i>
                            </button>
                        </div>
                        <form action="{{ route('admin.roles.destroy',$value['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="modal-body">
                                <h2>@lang('admin.delete_about')</h2>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">@lang('admin.not')</button>
                                <button type="submit" class="btn btn-sm btn-primary">@lang('admin.yes')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection

@section('admin.js')
    <script src="{{ asset('admin/assets/vendor/js/jquery.uploader.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/category.js') }}"></script>
@endsection
