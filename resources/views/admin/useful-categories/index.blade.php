@extends('admin.layouts.app')
@section('admin.title')
    @lang('admin.categories')
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
                        <h5>@lang('admin.categories')</h5>
                        <div class="btn-box d-flex flex-wrap gap-2">
                            <div id="tableSearch"></div>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addTaskModal"><i class="fa-light fa-plus"></i> @lang('admin.add')
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
                            @if(!empty($usefulCategories[0]) && isset($usefulCategories[0]))
                                @foreach($usefulCategories as $data)
                                    @if(empty($data['parent_id']))
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
                                                @if(!empty($data['parentCategories'][0]) && isset($data['parentCategories'][0]))
                                                    <button class="btn btn-sm btn-icon btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#eyeMain{{$data['id']}}"><i
                                                            class="fa-light fa-eye"></i>
                                                    </button>
                                                @endif
                                                <button class="btn btn-sm btn-icon btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#editMain{{$data['id']}}"><i
                                                        class="fa-light fa-edit"></i>
                                                </button>

                                                <button class="btn btn-sm btn-icon btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#deleteMain{{$data['id']}}"><i
                                                        class="fa-light fa-trash-can"></i></button>
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
                <form action="{{ route('admin.useful-categories.store') }}" method="POST">
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
                                                <label class="form-label">@lang('admin.title')
                                                    - {{$lang['code']}}</label>
                                                <input type="text" class="form-control" name="title[{{$lang['code']}}]">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <div class="tab-pane" id="other" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="input-category" class="form-label">@lang('admin.main_category')</label>
                                        <select class="form-control" name="parent_id" id="input-category">
                                            <option value="">@lang('admin.choose')</option>
                                            @foreach($mainUsefulCategories as $category)
                                                <option value="{{$category->id}}">{{ !empty(json_decode($category, true)['title'][$currentLang])? json_decode($category, true)['title'][$currentLang]: null }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12" id="sub-category-wrapper" style="display: none;">
                                        <label for="input-sub-category" class="form-label">@lang('admin.sub_category')</label>
                                        <select class="form-control" name="sub_parent_id" id="input-sub-category">
                                            <option value="">@lang('admin.choose')</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="form-label">@lang('admin.page_type')</label>
                                        <select class="form-control" name="page_type">
                                            <option value="">@lang('admin.choose')</option>
                                            <option value="files">@lang('admin.file')</option>
                                            <option value="file_content">@lang('admin.file_content')</option>
                                            <option value="image_content">@lang('admin.image_content')</option>
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

    @if(!empty($usefulCategories[0]) && isset($usefulCategories[0]))
        @foreach($usefulCategories as $value)
                <!-- edit task modal -->
                <div class="modal fade" id="editMain{{$value['id']}}" tabindex="-1" aria-labelledby="editMain{{$value['id']}}Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <form action="{{ route('admin.useful-categories.update',$value['id']) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <ul class="nav nav-pills nav-justified" role="tablist">
                                        @if(!empty($locales))
                                            @foreach($locales as $key => $lang)
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link @if(++$key ==1) active @endif" data-bs-toggle="tab" href="#edit-main{{$value['id']}}{{$lang->code}}" role="tab">
                                                        <span class="d-none d-sm-block">{{$lang->code}}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endif
                                        <li class="nav-item waves-effect waves-light">
                                            <a class="nav-link" data-bs-toggle="tab"
                                               href="#editother-main{{$value['id']}}" role="tab">
                                                <span class="d-none d-sm-block">@lang('admin.other')</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content p-3 text-muted">
                                        @if(!empty($locales))
                                            @foreach($locales as $key => $lang)
                                                <div class="tab-pane @if(++$key ==1) active @endif"
                                                     id="edit-main{{$value['id']}}{{$lang['code']}}" role="tabpanel">
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
                                        <div class="tab-pane" id="editother-main{{$value['id']}}" role="tabpanel">
                                            <div class="row g-3">
                                                @if(!empty($value['parent_id']))
                                                    <div class="col-md-12">
                                                        <label for="input-category" class="form-label">@lang('admin.main_category')</label>
                                                        <select class="form-control" name="parent_id" id="input-category">
                                                            <option value="">@lang('admin.choose')</option>
                                                            @foreach($mainUsefulCategories as $category)
                                                                <option value="{{$category->id}}" @if(!empty($value['parent_id']) && $value['parent_id'] == $category['id']) selected @endif>{{ !empty(json_decode($category, true)['title'][$currentLang])? json_decode($category, true)['title'][$currentLang]: null }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif
                                                <div class="col-sm-12">
                                                    <label class="form-label">@lang('admin.page_type')</label>
                                                    <select class="form-control" name="page_type">
                                                        <option value="" @if($value['page_type'] == '') selected @endif>@lang('admin.choose')</option>
                                                        <option value="files" @if($value['page_type'] == 'files') selected @endif>@lang('admin.file')</option>
                                                        <option value="file_content" @if($value['page_type'] == 'file_content') selected @endif>@lang('admin.file_content')</option>
                                                        <option value="image_content" @if($value['page_type'] == 'image_content') selected @endif>@lang('admin.image_content')</option>
                                                    </select>
                                                </div>
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
                <div class="modal fade" id="deleteMain{{$value['id']}}" tabindex="-1" aria-labelledby="deleteMain{{$value['id']}}Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title" id="deleteMain{{$value['id']}}Label">@lang('admin.delete')</h2>
                                <button type="button" class="btn btn-sm btn-icon btn-outline-primary" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fa-light fa-times"></i>
                                </button>
                            </div>
                            <form action="{{ route('admin.useful-categories.destroy',$value['id']) }}" method="POST">
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
                @if(!empty($value['parentCategories'][0]) && isset($value['parentCategories'][0]))
                    <!-- edit task modal -->
                    <div class="modal fade" id="eyeMain{{$value['id']}}" tabindex="-1" aria-labelledby="eyeMain{{$value['id']}}Label" aria-hidden="true">
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
                                    @foreach($value['parentCategories'] as $parentCategory)
                                        <tr>
                                            <td>{{ $parentCategory['id'] }}</td>
                                            <td>
                                                <div class="table-category-card">
                                                    <div class="part-txt">
                                                        <span class="category-name">{!! !empty($parentCategory['title'][$currentLang])? $parentCategory['title'][$currentLang]: null !!}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-box">
                                                    @if(!empty($parentCategory['subParentCategories'][0]) && isset($parentCategory['subParentCategories'][0]))
                                                        <button class="btn btn-sm btn-icon btn-primary" data-bs-toggle="modal"
                                                                data-bs-target="#eyeParent{{$parentCategory['id']}}"><i
                                                                class="fa-light fa-eye"></i>
                                                        </button>
                                                    @endif
                                                    <button class="btn btn-sm btn-icon btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#editParent{{$parentCategory['id']}}"><i
                                                            class="fa-light fa-edit"></i>
                                                    </button>

                                                    <button class="btn btn-sm btn-icon btn-danger" data-bs-toggle="modal"
                                                            data-bs-target="#deleteParent{{$parentCategory['id']}}"><i
                                                            class="fa-light fa-trash-can"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- edit task modal -->
                    @foreach($value['parentCategories'] as $parentCategory)
                    <div class="modal fade" id="editParent{{$parentCategory['id']}}" tabindex="-1" aria-labelledby="editParent{{$parentCategory['id']}}Label" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <form action="{{ route('admin.useful-categories.update',$parentCategory['id']) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <ul class="nav nav-pills nav-justified" role="tablist">
                                            @if(!empty($locales))
                                                @foreach($locales as $key => $lang)
                                                    <li class="nav-item waves-effect waves-light">
                                                        <a class="nav-link @if(++$key ==1) active @endif" data-bs-toggle="tab" href="#edit-parent{{$parentCategory['id']}}{{$lang->code}}" role="tab">
                                                            <span class="d-none d-sm-block">{{$lang->code}}</span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @endif
                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link" data-bs-toggle="tab"
                                                   href="#editother-parent{{$parentCategory['id']}}" role="tab">
                                                    <span class="d-none d-sm-block">@lang('admin.other')</span>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content p-3 text-muted">
                                            @if(!empty($locales))
                                                @foreach($locales as $key => $lang)
                                                    <div class="tab-pane @if(++$key ==1) active @endif"
                                                         id="edit-parent{{$parentCategory['id']}}{{$lang['code']}}" role="tabpanel">
                                                        <div class="row g-3">
                                                            <div class="col-12">
                                                                <label class="form-label">@lang('admin.title')
                                                                    - {{$lang['code']}}</label>
                                                                <input type="text" class="form-control"
                                                                       name="title[{{$lang['code']}}]"
                                                                       value="{{ !empty($parentCategory['title'][$lang['code']])? $parentCategory['title'][$lang['code']]: NULL }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <div class="tab-pane" id="editother-parent{{$parentCategory['id']}}" role="tabpanel">
                                                <div class="row g-3">
                                                    @if(!empty($parentCategory['parent_id']))
                                                        <div class="col-md-12">
                                                            <label for="input-category" class="form-label">@lang('admin.main_category')</label>
                                                            <select class="form-control" name="parent_id" id="input-category">
                                                                <option value="">@lang('admin.choose')</option>
                                                                @foreach($mainUsefulCategories as $category)
                                                                    <option value="{{$category->id}}" @if(!empty($parentCategory['parent_id']) && $parentCategory['parent_id'] == $category['id']) selected @endif>{{ !empty(json_decode($category, true)['title'][$currentLang])? json_decode($category, true)['title'][$currentLang]: null }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @endif
                                                    <div class="col-sm-12">
                                                        <label class="form-label">@lang('admin.page_type')</label>
                                                        <select class="form-control" name="page_type">
                                                            <option value="" @if($parentCategory['page_type'] == '') selected @endif>@lang('admin.choose')</option>
                                                            <option value="files" @if($parentCategory['page_type'] == 'files') selected @endif>@lang('admin.file')</option>
                                                            <option value="file_content" @if($parentCategory['page_type'] == 'file_content') selected @endif>@lang('admin.file_content')</option>
                                                            <option value="image_content" @if($parentCategory['page_type'] == 'image_content') selected @endif>@lang('admin.image_content')</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <label class="form-label">@lang('admin.status')</label>
                                                        <select class="form-control" name="status">
                                                            <option value="1" @if($parentCategory['status'] ==1) selected @endif>Aktiv</option>
                                                            <option value="0" @if($parentCategory['status'] ==0) selected @endif>Deactiv</option>
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
                    <div class="modal fade" id="deleteParent{{$parentCategory['id']}}" tabindex="-1" aria-labelledby="deleteParent{{$parentCategory['id']}}Label" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title" id="deletecategory{{$parentCategory['id']}}Label">@lang('admin.delete')</h2>
                                    <button type="button" class="btn btn-sm btn-icon btn-outline-primary" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="fa-light fa-times"></i>
                                    </button>
                                </div>
                                <form action="{{ route('admin.useful-categories.destroy',$parentCategory['id']) }}" method="POST">
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

                        @if(!empty($parentCategory['subParentCategories'][0]) && isset($parentCategory['subParentCategories'][0]))
                            <div class="modal fade" id="eyeParent{{$parentCategory['id']}}" tabindex="-1" aria-labelledby="eyeParent{{$parentCategory['id']}}Label" aria-hidden="true">
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
                                            @foreach($parentCategory['subParentCategories'] as $subParentCategory)
                                                <tr>
                                                    <td>{{ $subParentCategory['id'] }}</td>
                                                    <td>
                                                        <div class="table-category-card">
                                                            <div class="part-txt">
                                                                <span class="category-name">{!! !empty($subParentCategory['title'][$currentLang])? $subParentCategory['title'][$currentLang]: null !!}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="btn-box">
                                                            <button class="btn btn-sm btn-icon btn-primary" data-bs-toggle="modal"
                                                                    data-bs-target="#editSubParent{{$subParentCategory['id']}}"><i
                                                                    class="fa-light fa-edit"></i>
                                                            </button>

                                                            <button class="btn btn-sm btn-icon btn-danger" data-bs-toggle="modal"
                                                                    data-bs-target="#deleteSubParent{{$subParentCategory['id']}}"><i
                                                                    class="fa-light fa-trash-can"></i></button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            @foreach($parentCategory['subParentCategories'] as $subParentCategory)
                                <div class="modal fade" id="editSubParent{{$subParentCategory['id']}}" tabindex="-1" aria-labelledby="editSubParent{{$subParentCategory['id']}}Label" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.useful-categories.update',$subParentCategory['id']) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <ul class="nav nav-pills nav-justified" role="tablist">
                                                        @if(!empty($locales))
                                                            @foreach($locales as $key => $lang)
                                                                <li class="nav-item waves-effect waves-light">
                                                                    <a class="nav-link @if(++$key ==1) active @endif" data-bs-toggle="tab" href="#edit-subParent{{$subParentCategory['id']}}{{$lang->code}}" role="tab">
                                                                        <span class="d-none d-sm-block">{{$lang->code}}</span>
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                        <li class="nav-item waves-effect waves-light">
                                                            <a class="nav-link" data-bs-toggle="tab"
                                                               href="#editother-subParent{{$subParentCategory['id']}}" role="tab">
                                                                <span class="d-none d-sm-block">@lang('admin.other')</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content p-3 text-muted">
                                                        @if(!empty($locales))
                                                            @foreach($locales as $key => $lang)
                                                                <div class="tab-pane @if(++$key ==1) active @endif"
                                                                     id="edit-subParent{{$subParentCategory['id']}}{{$lang['code']}}" role="tabpanel">
                                                                    <div class="row g-3">
                                                                        <div class="col-12">
                                                                            <label class="form-label">@lang('admin.title')
                                                                                - {{$lang['code']}}</label>
                                                                            <input type="text" class="form-control"
                                                                                   name="title[{{$lang['code']}}]"
                                                                                   value="{{ !empty($subParentCategory['title'][$lang['code']])? $subParentCategory['title'][$lang['code']]: NULL }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                        <div class="tab-pane" id="editother-subParent{{$subParentCategory['id']}}" role="tabpanel">
                                                            <div class="row g-3">
                                                                @if(!empty($subParentCategory['parent_id']))
                                                                    <div class="col-md-12">
                                                                        <label for="input-category" class="form-label">@lang('admin.main_category')</label>
                                                                        <select class="form-control" name="parent_id" id="input-category">
                                                                            <option value="">@lang('admin.choose')</option>
                                                                            @foreach($mainUsefulCategories as $category)
                                                                                <option value="{{$category->id}}" @if(!empty($subParentCategory['parent_id']) && $parentCategory['parent_id'] == $category['id']) selected @endif>{{ !empty(json_decode($category, true)['title'][$currentLang])? json_decode($category, true)['title'][$currentLang]: null }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                @endif
                                                                <div class="col-sm-12">
                                                                    <label class="form-label">@lang('admin.page_type')</label>
                                                                    <select class="form-control" name="page_type">
                                                                        <option value="" @if($subParentCategory['page_type'] == '') selected @endif>@lang('admin.choose')</option>
                                                                        <option value="files" @if($subParentCategory['page_type'] == 'files') selected @endif>@lang('admin.file')</option>
                                                                        <option value="file_content" @if($subParentCategory['page_type'] == 'file_content') selected @endif>@lang('admin.file_content')</option>
                                                                        <option value="image_content" @if($subParentCategory['page_type'] == 'image_content') selected @endif>@lang('admin.image_content')</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <label class="form-label">@lang('admin.status')</label>
                                                                    <select class="form-control" name="status">
                                                                        <option value="1" @if($subParentCategory['status'] ==1) selected @endif>Aktiv</option>
                                                                        <option value="0" @if($subParentCategory['status'] ==0) selected @endif>Deactiv</option>
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
                                <div class="modal fade" id="deleteSubParent{{$subParentCategory['id']}}" tabindex="-1" aria-labelledby="deleteSubParent{{$subParentCategory['id']}}Label" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h2 class="modal-title" id="deleteSubParent{{$subParentCategory['id']}}Label">@lang('admin.delete')</h2>
                                                <button type="button" class="btn btn-sm btn-icon btn-outline-primary" data-bs-dismiss="modal" aria-label="Close">
                                                    <i class="fa-light fa-times"></i>
                                                </button>
                                            </div>
                                            <form action="{{ route('admin.useful-categories.destroy',$subParentCategory['id']) }}" method="POST">
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
                    @endforeach
                @endif
        @endforeach
    @endif
@endsection
@section('admin.js')
    <script>
        $(document).ready(function () {
            $('#input-category').on('change', function () {
                let parentId = $(this).val();
                let subCategoryWrapper = $('#sub-category-wrapper');
                let subCategorySelect = $('#input-sub-category');

                // Əgər parent_id boşdursa, sub_category selectini gizlədirik
                if (!parentId) {
                    subCategoryWrapper.hide();
                    subCategorySelect.html('<option value="">@lang("admin.choose")</option>');
                    return;
                }

                // AJAX ilə alt kateqoriyaları gətiririk
                $.ajax({
                    url: '{{ route('admin.useful-categories.getParentCategories') }}', // Bu URL `web.php` faylında göstərilməlidir
                    type: 'GET',
                    data: { category_id: parentId },
                    success: function (response) {
                        if (response.success && response.parentCategories.length > 0) {
                            // Alt kateqoriyaları doldur
                            subCategorySelect.html('<option value="">@lang("admin.choose")</option>');
                            $.each(response.parentCategories, function (index, subCategory) {
                                subCategorySelect.append(
                                    `<option value="${subCategory.id}">${subCategory.title}</option>`
                                );
                            });
                            subCategoryWrapper.show();
                        } else {
                            // Alt kateqoriya yoxdursa, seçimi gizlət
                            subCategoryWrapper.hide();
                            subCategorySelect.html('<option value="">@lang("admin.choose")</option>');
                        }
                    },
                    error: function () {
                        alert('@lang("admin.error_loading_categories")');
                    }
                });
            });
        });
    </script>
    <script src="{{ asset('admin/assets/vendor/js/jquery.uploader.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/category.js') }}"></script>
@endsection
