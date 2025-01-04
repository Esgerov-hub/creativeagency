@extends('admin.layouts.app')
@section('admin.title')
    @lang('admin.positions')
@endsection
@section('admin.css')
    <meta name="_token" content="{{ csrf_token() }}">
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
                        <h5>@lang('admin.positions')</h5>
                        <div class="btn-box d-flex flex-wrap gap-2">
                            <div id="tableSearch"></div>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                                <i class="fa-light fa-plus"></i> @lang('admin.add')
                            </button>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-dashed table-hover digi-dataTable task-table table-striped"
                               id="taskTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('admin.title')</th>
                                <th>@lang('admin.settings')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($positions[0]) && isset($positions[0]))
                                @foreach($positions as $data)
                                    <tr>
                                        <td>{{ $data['id'] }}</td>
                                        <td>
                                            <div class="table-category-card">
                                                <div class="part-txt">
                                                    <span class="category-name">{!! !empty($data['title'][$currentLang])? $data['title'][$currentLang]: null !!}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-box">
                                                @if(!empty($data['parent'][0]) && isset($data['parent'][0]))
                                                    <button class="btn btn-sm btn-icon btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#eyeTaskModal{{$data['id']}}"><i
                                                            class="fa-light fa-eye"></i>
                                                    </button>
                                                @endif
                                                <button class="btn btn-sm btn-icon btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#editTaskModal{{$data['id']}}"><i
                                                        class="fa-light fa-edit"></i>
                                                </button>

                                                <button class="btn btn-sm btn-icon btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#deletecategory{{$data['id']}}"><i
                                                        class="fa-light fa-trash-can"></i></button>
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
    </div>
    <!-- main content end -->

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
                <form action="{{ route('admin.positions.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <ul class="nav nav-pills nav-justified" role="tablist">
                            @if(!empty($locales))
                                @foreach($locales as $key => $lang)
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link @if(++$key ==1) active @endif" data-bs-toggle="tab"
                                           href="#{{$lang->code}}" role="tab">
                                            <span class="d-none d-sm-block">{{$lang->code}}</span>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                            <li class="nav-item waves-effect waves-light">
                                <a class="nav-link" data-bs-toggle="tab"
                                   href="#other" role="tab">
                                    <span class="d-none d-sm-block">@lang('admin.other')</span>
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
                                                <label class="form-label">@lang('admin.title')- {{$lang['code']}}</label>
                                                <input type="text" class="form-control" name="title[{{$lang['code']}}]">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <div class="tab-pane" id="other" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-sm-12">
                                        <label class="form-label">@lang('admin.main_positions')</label>
                                        <select class="form-control" name="parent_id" id="input-category">
                                            <option value="">@lang('admin.choose')</option>
                                            @foreach($positions as $mainPosition)
                                                <option value="{{$mainPosition->id}}">{{ !empty(json_decode($mainPosition, true)['title'][$currentLang])? json_decode($mainPosition, true)['title'][$currentLang]: null }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="form-label">@lang('admin.status')</label>
                                        <select class="form-control" name="status">
                                            <option value="1" >Aktiv</option>
                                            <option value="0" >Deactiv</option>
                                        </select>
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

    @if(!empty($positions[0]) && isset($positions[0]))
        @foreach($positions as $value)
            <!-- edit task modal -->
            <div class="modal fade" id="eyeTaskModal{{$value['id']}}" tabindex="-1"
                 aria-labelledby="eyeTaskModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <table class="table table-dashed table-hover digi-dataTable task-table table-striped"
                               id="taskTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('admin.title')</th>
                                <th>@lang('admin.settings')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($value['parent'][0]) && isset($value['parent'][0]))
                                @foreach($value['parent'] as $parent)
                                    <tr>
                                        <td>{{ $parent['id'] }}</td>
                                        <td>
                                            <div class="table-category-card">
                                                <div class="part-txt">
                                                    <span class="category-name">{!! !empty($parent['title'][$currentLang])? $parent['title'][$currentLang]: null !!}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-box">
                                                <button class="btn btn-sm btn-icon btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#editParent{{$parent['id']}}"><i
                                                        class="fa-light fa-edit"></i>
                                                </button>

                                                <button class="btn btn-sm btn-icon btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#deleteParent{{$parent['id']}}"><i
                                                        class="fa-light fa-trash-can"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @if(!empty($value['parent'][0]) && isset($value['parent'][0]))
                @foreach($value['parent'] as $parent)
                    <div class="modal fade" id="editParent{{$parent['id']}}" tabindex="-1"
                         aria-labelledby="editParentLabel"
                         aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <form action="{{ route('admin.positions.update',$parent['id']) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <ul class="nav nav-pills nav-justified" role="tablist">
                                            @if(!empty($locales))
                                                @foreach($locales as $key => $lang)
                                                    <li class="nav-item waves-effect waves-light">
                                                        <a class="nav-link @if(++$key ==1) active @endif" data-bs-toggle="tab" href="#editParentLang{{$lang['id']}}{{$lang->code}}" role="tab">
                                                            <span class="d-none d-sm-block">{{$lang->code}}</span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @endif
                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link" data-bs-toggle="tab"
                                                   href="#editother{{$parent['id']}}" role="tab">
                                                    <span class="d-none d-sm-block">@lang('admin.other')</span>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content p-3 text-muted">
                                            @if(!empty($locales))
                                                @foreach($locales as $key => $lang)
                                                    <div class="tab-pane @if(++$key ==1) active @endif"
                                                         id="editParentLang{{$lang['id']}}{{$lang['code']}}" role="tabpanel">
                                                        <div class="row g-3">
                                                            <div class="col-12">
                                                                <label class="form-label">@lang('admin.title')
                                                                    - {{$lang['code']}}</label>
                                                                <input type="text" class="form-control"
                                                                       name="title[{{$lang['code']}}]"
                                                                       value="{{ !empty($parent['title'][$lang['code']])? $parent['title'][$lang['code']]: NULL }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <div class="tab-pane" id="editother{{$parent['id']}}" role="tabpanel">
                                                <div class="row g-3">
                                                    <div class="col-sm-12">
                                                        <label class="form-label">@lang('admin.main_positions')</label>
                                                        <select class="form-control" name="parent_id" id="input-category">
                                                            <option value="">@lang('admin.choose')</option>
                                                            @foreach($positions as $mainPosition)
                                                                <option value="{{$mainPosition->id}}" @if($mainPosition->id == $parent['parent_id']) selected @endif>{{ !empty(json_decode($mainPosition, true)['title'][$currentLang])? json_decode($mainPosition, true)['title'][$currentLang]: null }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <label class="form-label">@lang('admin.status')</label>
                                                        <select class="form-control" name="status">
                                                            <option value="1" @if($parent['status'] ==1) selected @endif>Aktiv</option>
                                                            <option value="0" @if($parent['status'] ==0) selected @endif>Deactiv</option>
                                                        </select>
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
                    <div class="modal fade" id="deleteParent{{$parent['id']}}" tabindex="-1" aria-labelledby="deleteParent{{$parent['id']}}Label" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title" id="deleteParent{{$parent['id']}}Label">@lang('admin.delete')</h2>
                                    <button type="button" class="btn btn-sm btn-icon btn-outline-primary"
                                            data-bs-dismiss="modal" aria-label="Close"><i class="fa-light fa-times"></i>
                                    </button>
                                </div>
                                <form action="{{ route('admin.positions.destroy',$parent['id']) }}" method="POST">
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

            <!-- edit task modal -->
            <div class="modal fade" id="editTaskModal{{$value['id']}}" tabindex="-1"
                 aria-labelledby="editTaskModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <form action="{{ route('admin.positions.update',$value['id']) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <ul class="nav nav-pills nav-justified" role="tablist">
                                    @if(!empty($locales))
                                        @foreach($locales as $key => $lang)
                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link @if(++$key ==1) active @endif" data-bs-toggle="tab" href="#edit{{$value['id']}}{{$lang->code}}" role="tab">
                                                    <span class="d-none d-sm-block">{{$lang->code}}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link" data-bs-toggle="tab"
                                           href="#editother{{$value['id']}}" role="tab">
                                            <span class="d-none d-sm-block">@lang('admin.other')</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content p-3 text-muted">
                                    @if(!empty($locales))
                                        @foreach($locales as $key => $lang)
                                            <div class="tab-pane @if(++$key ==1) active @endif"
                                                 id="edit{{$value['id']}}{{$lang['code']}}" role="tabpanel">
                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <label class="form-label">@lang('admin.title')
                                                            - {{$lang['code']}}</label>
                                                        <input type="text" class="form-control"
                                                               name="title[{{$lang['code']}}]"
                                                               value="{{ !empty($value['title'][$lang['code']])? $value['title'][$lang['code']]: NULL }}">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="tab-pane" id="editother{{$value['id']}}" role="tabpanel">
                                        <div class="row g-3">
                                            <div class="col-sm-12">
                                                <label class="form-label">@lang('admin.status')</label>
                                                <select class="form-control" name="status">
                                                    <option value="1" @if($value['status'] ==1) selected @endif>Aktiv</option>
                                                    <option value="0" @if($value['status'] ==0) selected @endif>Deactiv</option>
                                                </select>
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
            <!-- edit task modal -->
            <div class="modal fade" id="deletecategory{{$value['id']}}" tabindex="-1" aria-labelledby="deletecategory{{$value['id']}}Label" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title" id="deletecategory{{$value['id']}}Label">@lang('admin.delete')</h2>
                            <button type="button" class="btn btn-sm btn-icon btn-outline-primary"
                                    data-bs-dismiss="modal" aria-label="Close"><i class="fa-light fa-times"></i>
                            </button>
                        </div>
                        <form action="{{ route('admin.positions.destroy',$value['id']) }}" method="POST">
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
