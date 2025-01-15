@extends('admin.layouts.app')
@section('admin.title')
    @lang('admin.permissions')
@endsection
@section('admin.css')
@endsection
@section('admin.content')
    <div class="main-content">
        @include('components.admin.error')
        <div class="dashboard-breadcrumb mb-25">
            <h2>@lang('admin.permissions')</h2>
            <div class="btn-box d-flex flex-wrap gap-2">
                <div id="tableSearch"></div>

                @can('permissions-create')
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addTaskModal"><i class="fa-light fa-plus"></i> @lang('admin.add')
                </button>
                @endcan
            </div>
        </div>
        <div class="row">
            @foreach($permissionLabels as $label)
            <div class="col-md-6">
                <div class="panel">
                    <div class="panel-body">
                        <div class="list-group">
                            <div class="list-group-item"><span class="text-warning"><i class="fa-solid fa-folder-open"></i></span>
                                {{$label['label']}}
                                <div class="list-group">
                                    @foreach($label['permissions'] as $permission)
                                    <div class="list-group-item"><span class="text-primary"><i class="fa-brands fa-css3"></i></span> {!! $permission['name'] !!}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- add new task modal -->
    <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="addTaskModalLabel">@lang('admin.add')</h2>
                    <button type="button" class="btn btn-sm btn-icon btn-outline-primary" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-light fa-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.permissions.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="other" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-sm-12">
                                        <label class="form-label">@lang('admin.label')</label>
                                        <input type="text" class="form-control" name="label" placeholder="Mess: users">
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="form-label">@lang('admin.permission')</label>
                                        <input type="text" class="form-control" name="permissions" placeholder="Mess: users-view, users-create ve s.">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">@lang('admin.close')</button>
                        <button type="submit" class="btn btn-sm btn-primary">@lang('admin.save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- add new task modal -->
@endsection
@section('admin.js')
@endsection

