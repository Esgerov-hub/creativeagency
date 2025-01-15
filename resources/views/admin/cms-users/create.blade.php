@extends('admin.layouts.app')
@section('admin.title')
    @lang('admin.cms_users')
@endsection
@section('admin.css')
@endsection
@section('admin.content')
    <div class="main-content">
        <div class="dashboard-breadcrumb mb-25">
            <h2>@lang('admin.cms_users')</h2>
        </div>
        @include('components.admin.error')
        <div class="row">
            <div class="col-12">
                <form action="{{ route('admin.cms-users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="panel">
                        <div class="panel-body">
                            <div class="tab-content profile-edit-tab" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-edit-profile" role="tabpanel"
                                     aria-labelledby="nav-edit-profile-tab" tabindex="0">

                                    <div class="private-information mb-25">
                                        <div class="row g-3">
                                            <div class="col-sm-6">
                                                <label class="form-label">@lang('admin.name')</label>
                                                <input type="text" class="form-control" value="{{ old('name') }}" name="name">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label">@lang('admin.surname')</label>
                                                <input type="text" class="form-control" value="{{ old('surname') }}" name="surname">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label">@lang('admin.father_name')</label>
                                                <input type="text" class="form-control" value="{{ old('father_name') }}" name="father_name">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label">@lang('admin.phone')</label>
                                                <input type="text" class="form-control" value="{{ old('phone') }}" name="phone">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label">@lang('admin.Email')</label>
                                                <input type="email" class="form-control" value="{{ old('email') }}" name="email">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label">@lang('admin.Password')</label>
                                                <input type="password" class="form-control" value="" name="password">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label">@lang('admin.roles')</label>
                                                <select class="form-control" name="role">
                                                        <option value="">@lang('admin.choose')</option>
                                                        @foreach($roles as $role)
                                                            @if($role['id'] !=1)
                                                            <option value="{{$role['name']}}" @if($role['id'] == old('role')) selected="selected" @endif>{{$role['name']}}</option>
                                                            @endif
                                                        @endforeach
                                                </select>
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="form-label">@lang('admin.status')</label>
                                                <select class="form-control" name="status">
                                                    <option value="1"  @if( '1' == old('status')) selected="selected" @endif>Aktiv</option>
                                                    <option value="0"  @if( '2' == old('status')) selected="selected" @endif>Deactiv</option>
                                                </select>
                                            </div>
                                        </div>
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
