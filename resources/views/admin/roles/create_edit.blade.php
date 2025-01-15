@extends('admin.layouts.app')
@section('admin.title')
    @lang('admin.roles')
@endsection
@section('admin.css')
@endsection
@section('admin.content')
    <div class="main-content">
        <div class="dashboard-breadcrumb mb-25">
            <h2>@lang('admin.roles')</h2>
        </div>
        @include('components.admin.error')
        <div class="row">
            <div class="col-12">
                <form action="{{ !empty($role)? route('admin.roles.update',$role['id']): route('admin.roles.store') }}" method="POST" >
                    @csrf
                    @if(!empty($role))
                    @method('PUT')
                    @endif
                    <div class="panel">
                        <div class="panel-header">
                            <nav>
                                <div class="btn-box d-flex flex-wrap gap-1" id="nav-tab" role="tablist">
                                    <input {{--@if(!empty($role)) disabled="disabled" @endif--}} class="form-control" type="text" name="role" value="{{!empty($role['name'])? $role['name']: old('name')}}" placeholder="mes: admin,user">
                                </div>
                            </nav>
                        </div>
                        <div class="panel-body">
                            <div class="tab-content profile-edit-tab" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-other-settings" role="tabpanel" aria-labelledby="nav-other-settings-tab" tabindex="0">
                                    <div class="row">
                                        @foreach($permissionLabels as $label)
                                        <div class="col-sm-6">
                                            <div class="profile-edit-tab-title">
                                                <h6>@lang('admin.'.$label['label'])</h6>
                                            </div>
                                            <div class="activity-email-settings">
                                                @foreach($label->permissions as $permission)
                                                    <div class="form-check mb-15">
                                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                               @if (!empty($selectedPermissions) && in_array($permission->name, $selectedPermissions)) checked="checked"
                                                               @endif id="activity-email-settings-1">
                                                        <label class="form-check-label" for="activity-email-settings-1">
                                                            <?php
                                                            $name = $permission['name'];
                                                            $parts = explode('-', $name);

                                                            if (count($parts) > 2) {
                                                                $partAfterDash = end($parts); // Sonuncu hissəni götür
                                                            } elseif (count($parts) === 2) {
                                                                $partAfterDash = $parts[1]; // İkinci hissəni götür
                                                            } else {
                                                                $partAfterDash = ''; // Heç bir şey yoxdursa boş qaytar
                                                            }
                                                            ?>
                                                            @lang('admin.'.$partAfterDash)
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">@lang('admin.save')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('admin.js')
@endsection
