@extends('admin.layouts.app')
@section('admin.title')
    @lang('admin.cms_users')
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
                        <h5>@lang('admin.cms_users')</h5>
                        <div class="btn-box d-flex flex-wrap gap-2">
                            <div id="tableSearch"></div>
                            @can('cms_users-create')
                            <a class="btn btn-sm btn-primary" href="{{ route('admin.cms-users.create') }}"><i
                                    class="fa-light fa-plus"></i> @lang('admin.add')
                            </a>
                            @endcan
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-dashed table-hover digi-dataTable task-table table-striped" id="taskTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('admin.full_name')</th>
                                <th>@lang('admin.roles')</th>
                                <th>@lang('admin.phone')</th>
                                <th>@lang('admin.Email')</th>
                                <th>@lang('admin.settings')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($cms_users[0]) && isset($cms_users[0]))
                                @foreach($cms_users as $data)
                                    @if($data['id'] != 1)
                                    <tr>
                                        <td>{{ $data['id'] }}</td>
                                        <td>
                                            <div class="table-category-card">
                                                <div class="part-txt">
                                                    <span
                                                        class="category-name">{!! $data['name'] !!} {!! $data['surname'] !!} {!! $data['father_name'] !!}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{!! $data['type'] !!}</td>
                                        <td>{!! $data['phone'] !!}</td>
                                        <td>{!! $data['email'] !!}</td>
                                        <td>
                                            <div class="btn-box">

                                                @can('cms_users-edit')
                                                <a href="{{ route('admin.cms-users.edit',$data['id']) }}"
                                                   class="btn btn-sm btn-icon btn-primary"
                                                   title="@lang('admin.edit')"><i
                                                        class="fa-light fa-edit"></i>
                                                </a>
                                                @endcan
                                                @can('cms_users-delete')
                                                <button class="btn btn-sm btn-icon btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#delete{{$data['id']}}">
                                                    <i class="fa-light fa-trash-can"></i>
                                                </button>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
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
    @if(!empty($cms_users[0]) && isset($cms_users[0]))
        @foreach($cms_users as $value)
            <div class="modal fade" id="delete{{$value['id']}}" tabindex="-1"
                 aria-labelledby="deletecategory{{$value['id']}}Label" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title" id="deletecategory{{$value['id']}}Label">{{$value['name']}} {{$value['surname']}} -@lang('admin.delete')</h2>
                            <button type="button" class="btn btn-sm btn-icon btn-outline-primary"
                                    data-bs-dismiss="modal" aria-label="Close"><i class="fa-light fa-times"></i>
                            </button>
                        </div>
                        <form action="{{ route('admin.cms-users.destroy',$value['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="modal-body">
                                <h2>@lang('admin.delete_about')</h2>
                            </div>
                            <div class="modal-footer">
                                 <button type="button" class="btn btn-sm btn-secondary"
                                         data-bs-dismiss="modal">@lang('admin.not')</button>
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

