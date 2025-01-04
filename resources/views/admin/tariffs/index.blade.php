@extends('admin.layouts.app')
@section('admin.title')
    @lang('admin.tariffs')
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
                        <h5>@lang('admin.tariffs')</h5>
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
                            @if(!empty($tariffs[0]) && isset($tariffs[0]))
                                @foreach($tariffs as $data)
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
                                                @if(!empty($data['parentTariff'][0]) && isset($data['parentTariff'][0]))
                                                    <button class="btn btn-sm btn-icon btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#eyeParent{{$data['id']}}"><i
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
                <form action="{{ route('admin.tariff.store') }}" method="POST">
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
                                            <div class="col-12">
                                                <label class="form-label">@lang('admin.unit_of_measure')
                                                    - {{$lang['code']}}</label>
                                                <input type="text" class="form-control" name="unit_of_measure[{{$lang['code']}}]">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">@lang('admin.service_charge')
                                                    - {{$lang['code']}}</label>
                                                <input type="text" class="form-control" name="service_charge[{{$lang['code']}}]">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <div class="tab-pane" id="other" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="category_id" class="form-label">@lang('admin.category')</label>
                                        <select class="form-control" name="category_id" id="category_id">
                                            <option value="">@lang('admin.choose')</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{ !empty(json_decode($category, true)['title'][$currentLang])? json_decode($category, true)['title'][$currentLang]: null }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="input-tariff" class="form-label">@lang('admin.main_tariff')</label>
                                        <select class="form-control" name="parent_id" id="input-tariff">
                                            <option value="">@lang('admin.choose')</option>
                                            @foreach($mainTariff as $mainTariffItem)
                                                <option value="{{$mainTariffItem->id}}">{{ !empty(json_decode($mainTariffItem, true)['title'][$currentLang])? json_decode($mainTariffItem, true)['title'][$currentLang]: null }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12" id="sub-tariff-wrapper" style="display: none;">
                                        <label for="input-sub-tariff" class="form-label">@lang('admin.sub_tariff')</label>
                                        <select class="form-control" name="sub_parent_id" id="input-sub-tariff">
                                            <option value="">@lang('admin.choose')</option>
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
    @if(!empty($tariffs[0]) && isset($tariffs[0]))
        @foreach($tariffs as $value)

                @foreach($value['parentTariff'] as $parentTariffValue)
                        @foreach($parentTariffValue['subParentTariff'] as $subParentTariff)
                            <div class="modal fade" id="editSub{{$subParentTariff['id']}}" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.tariff.update',$subParentTariff['id']) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <ul class="nav nav-pills nav-justified" role="tablist">
                                                    @if(!empty($locales))
                                                        @foreach($locales as $key => $lang)
                                                            <li class="nav-item waves-effect waves-light">
                                                                <a class="nav-link @if(++$key ==1) active @endif" data-bs-toggle="tab" href="#editParentSub{{$subParentTariff['id']}}{{$lang->code}}" role="tab">
                                                                    <span class="d-none d-sm-block">{{$lang->code}}</span>
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                    <li class="nav-item waves-effect waves-light">
                                                        <a class="nav-link" data-bs-toggle="tab"
                                                           href="#editParentSubOther{{$subParentTariff['id']}}" role="tab">
                                                            <span class="d-none d-sm-block">@lang('admin.other')</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content p-3 text-muted">
                                                    @if(!empty($locales))
                                                        @foreach($locales as $key => $lang)
                                                            <div class="tab-pane @if(++$key ==1) active @endif"
                                                                 id="editParentSub{{$subParentTariff['id']}}{{$lang['code']}}" role="tabpanel">
                                                                <div class="row g-3">
                                                                    <div class="col-12">
                                                                        <label class="form-label">@lang('admin.title')
                                                                            - {{$lang['code']}}</label>
                                                                        <input type="text" class="form-control"
                                                                               name="title[{{$lang['code']}}]"
                                                                               value="{{ !empty($subParentTariff['title'][$lang['code']])? $subParentTariff['title'][$lang['code']]: NULL }}">
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label class="form-label">@lang('admin.unit_of_measure')
                                                                            - {{$lang['code']}}</label>
                                                                        <input type="text" class="form-control"
                                                                               name="unit_of_measure[{{$lang['code']}}]"
                                                                               value="{{ !empty($subParentTariff['unit_of_measure'][$lang['code']])? $subParentTariff['unit_of_measure'][$lang['code']]: NULL }}">
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label class="form-label">@lang('admin.service_charge')
                                                                            - {{$lang['code']}}</label>
                                                                        <input type="text" class="form-control"
                                                                               name="service_charge[{{$lang['code']}}]"
                                                                               value="{{ !empty($subParentTariff['service_charge'][$lang['code']])? $subParentTariff['service_charge'][$lang['code']]: NULL }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                    <div class="tab-pane" id="editParentSubOther{{$subParentTariff['id']}}" role="tabpanel">
                                                        <div class="row g-3">
                                                            <div class="col-md-12">
                                                                <label for="category_id" class="form-label">@lang('admin.category')</label>
                                                                <select class="form-control" name="category_id" id="category_id">
                                                                    <option value="">@lang('admin.choose')</option>
                                                                    @foreach($categories as $category)
                                                                        <option value="{{$category->id}}"  @if(!empty($subParentTariff['category_id']) && $subParentTariff['category_id'] == $category['id']) selected @endif>{{ !empty(json_decode($category, true)['title'][$currentLang])? json_decode($category, true)['title'][$currentLang]: null }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            @if(!empty($subParentTariff['parent_id']))
                                                                <div class="col-md-12">
                                                                    <label for="input-input-tariff" class="form-label">@lang('admin.main_category')</label>
                                                                    <select class="form-control" name="parent_id" id="input-tariff">
                                                                        <option value="">@lang('admin.choose')</option>
                                                                        @foreach($mainTariff as $main)
                                                                            <option value="{{$main->id}}" @if(!empty($subParentTariff['parent_id']) && $subParentTariff['parent_id'] == $main['id']) selected @endif>{{ !empty(json_decode($main, true)['title'][$currentLang])? json_decode($main, true)['title'][$currentLang]: null }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            @endif
                                                            <div class="col-sm-12">
                                                                <label class="form-label">@lang('admin.status')</label>
                                                                <select class="form-control" name="status">
                                                                    <option value="1" @if($subParentTariff['status'] ==1) selected @endif>Aktiv</option>
                                                                    <option value="0" @if($subParentTariff['status'] ==0) selected @endif>Deactiv</option>
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
                            <div class="modal fade" id="deleteSub{{$subParentTariff['id']}}" tabindex="-1" aria-labelledby="deleteSub{{$subParentTariff['id']}}Label" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title" id="deleteSub{{$subParentTariff['id']}}Label">@lang('admin.delete')</h2>
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-primary" data-bs-dismiss="modal" aria-label="Close">
                                                <i class="fa-light fa-times"></i>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.tariff.destroy',$parentTariffValue['id']) }}" method="POST">
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
                        <div class="modal fade" id="eyeSub{{$parentTariffValue['id']}}" tabindex="-1" aria-labelledby="eyeSubLabel" aria-hidden="true">
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
                                        @foreach($parentTariffValue['subParentTariff'] as $sunParentTariffValue)
                                            <tr>
                                                <td>{{ $sunParentTariffValue['id'] }}</td>
                                                <td>
                                                    <div class="table-category-card">
                                                        <div class="part-txt">
                                                            <span class="category-name">{!! !empty($sunParentTariffValue['title'][$currentLang])? $sunParentTariffValue['title'][$currentLang]: null !!}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-box">
                                                        <button class="btn btn-sm btn-icon btn-primary" data-bs-toggle="modal"
                                                                data-bs-target="#editSub{{$sunParentTariffValue['id']}}"><i
                                                                class="fa-light fa-edit"></i>
                                                        </button>

                                                        <button class="btn btn-sm btn-icon btn-danger" data-bs-toggle="modal"
                                                                data-bs-target="#deleteSub{{$sunParentTariffValue['id']}}"><i
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
                        <div class="modal fade" id="editParent{{$parentTariffValue['id']}}" tabindex="-1" aria-labelledby="editParent{{$parentTariffValue['id']}}Label" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('admin.tariff.update',$parentTariffValue['id']) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <ul class="nav nav-pills nav-justified" role="tablist">
                                                @if(!empty($locales))
                                                    @foreach($locales as $key => $lang)
                                                        <li class="nav-item waves-effect waves-light">
                                                            <a class="nav-link @if(++$key ==1) active @endif" data-bs-toggle="tab" href="#editParent{{$parentTariffValue['id']}}{{$lang->code}}" role="tab">
                                                                <span class="d-none d-sm-block">{{$lang->code}}</span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                @endif
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link" data-bs-toggle="tab"
                                                       href="#editParentOther{{$parentTariffValue['id']}}" role="tab">
                                                        <span class="d-none d-sm-block">@lang('admin.other')</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content p-3 text-muted">
                                                @if(!empty($locales))
                                                    @foreach($locales as $key => $lang)
                                                        <div class="tab-pane @if(++$key ==1) active @endif"
                                                             id="editParent{{$parentTariffValue['id']}}{{$lang['code']}}" role="tabpanel">
                                                            <div class="row g-3">
                                                                <div class="col-12">
                                                                    <label class="form-label">@lang('admin.title')
                                                                        - {{$lang['code']}}</label>
                                                                    <input type="text" class="form-control"
                                                                           name="title[{{$lang['code']}}]"
                                                                           value="{{ !empty($parentTariffValue['title'][$lang['code']])? $parentTariffValue['title'][$lang['code']]: NULL }}">
                                                                </div>
                                                                <div class="col-12">
                                                                    <label class="form-label">@lang('admin.unit_of_measure')
                                                                        - {{$lang['code']}}</label>
                                                                    <input type="text" class="form-control"
                                                                           name="unit_of_measure[{{$lang['code']}}]"
                                                                           value="{{ !empty($parentTariffValue['unit_of_measure'][$lang['code']])? $parentTariffValue['unit_of_measure'][$lang['code']]: NULL }}">
                                                                </div>
                                                                <div class="col-12">
                                                                    <label class="form-label">@lang('admin.service_charge')
                                                                        - {{$lang['code']}}</label>
                                                                    <input type="text" class="form-control"
                                                                           name="service_charge[{{$lang['code']}}]"
                                                                           value="{{ !empty($parentTariffValue['service_charge'][$lang['code']])? $parentTariffValue['service_charge'][$lang['code']]: NULL }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                <div class="tab-pane" id="editParentOther{{$parentTariffValue['id']}}" role="tabpanel">
                                                    <div class="row g-3">
                                                        <div class="col-md-12">
                                                            <label for="category_id" class="form-label">@lang('admin.category')</label>
                                                            <select class="form-control" name="category_id" id="category_id">
                                                                <option value="">@lang('admin.choose')</option>
                                                                @foreach($categories as $category)
                                                                    <option value="{{$category->id}}"  @if(!empty($parentTariffValue['category_id']) && $parentTariffValue['category_id'] == $category['id']) selected @endif>{{ !empty(json_decode($category, true)['title'][$currentLang])? json_decode($category, true)['title'][$currentLang]: null }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @if(!empty($parentTariffValue['parent_id']))
                                                            <div class="col-md-12">
                                                                <label for="input-tariff" class="form-label">@lang('admin.main_tariff')</label>
                                                                <select class="form-control" name="parent_id" id="input-tariff">
                                                                    <option value="">@lang('admin.choose')</option>
                                                                    @foreach($mainTariff as $main)
                                                                        <option value="{{$main->id}}" @if(!empty($parentTariffValue['parent_id']) && $parentTariffValue['parent_id'] == $main['id']) selected @endif>{{ !empty(json_decode($main, true)['title'][$currentLang])? json_decode($main, true)['title'][$currentLang]: null }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        @endif
                                                        <div class="col-sm-12">
                                                            <label class="form-label">@lang('admin.status')</label>
                                                            <select class="form-control" name="status">
                                                                <option value="1" @if($parentTariffValue['status'] ==1) selected @endif>Aktiv</option>
                                                                <option value="0" @if($parentTariffValue['status'] ==0) selected @endif>Deactiv</option>
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
                        <div class="modal fade" id="deleteParent{{$parentTariffValue['id']}}" tabindex="-1" aria-labelledby="deleteParent{{$parentTariffValue['id']}}Label" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2 class="modal-title" id="deleteParent{{$parentTariffValue['id']}}Label">@lang('admin.delete')</h2>
                                        <button type="button" class="btn btn-sm btn-icon btn-outline-primary" data-bs-dismiss="modal" aria-label="Close">
                                            <i class="fa-light fa-times"></i>
                                        </button>
                                    </div>
                                    <form action="{{ route('admin.tariff.destroy',$parentTariffValue['id']) }}" method="POST">
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
                <div class="modal fade" id="eyeParent{{$value['id']}}" tabindex="-1" aria-labelledby="eyeTaskModalLabel" aria-hidden="true">
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
                                @foreach($value['parentTariff'] as $parentTariff)
                                    <tr>
                                        <td>{{ $parentTariff['id'] }}</td>
                                        <td>
                                            <div class="table-category-card">
                                                <div class="part-txt">
                                                    <span class="category-name">{!! !empty($parentTariff['title'][$currentLang])? $parentTariff['title'][$currentLang]: null !!}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-box">
                                                @if(!empty($parentTariff['subParentTariff'][0]) && isset($parentTariff['subParentTariff'][0]))
                                                    <button class="btn btn-sm btn-icon btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#eyeSub{{$parentTariff['id']}}"><i
                                                            class="fa-light fa-eye"></i>
                                                    </button>
                                                @endif
                                                <button class="btn btn-sm btn-icon btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#editParent{{$parentTariff['id']}}"><i
                                                        class="fa-light fa-edit"></i>
                                                </button>

                                                <button class="btn btn-sm btn-icon btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#deleteParent{{$parentTariff['id']}}"><i
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
                <div class="modal fade" id="editMain{{$value['id']}}" tabindex="-1"
                     aria-labelledby="editTaskModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <form action="{{ route('admin.tariff.update',$value['id']) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <ul class="nav nav-pills nav-justified" role="tablist">
                                        @if(!empty($locales))
                                            @foreach($locales as $key => $lang)
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link @if(++$key ==1) active @endif" data-bs-toggle="tab" href="#editMain{{$value['id']}}{{$lang->code}}" role="tab">
                                                        <span class="d-none d-sm-block">{{$lang->code}}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endif
                                        <li class="nav-item waves-effect waves-light">
                                            <a class="nav-link" data-bs-toggle="tab"
                                               href="#editMainOther{{$value['id']}}" role="tab">
                                                <span class="d-none d-sm-block">@lang('admin.other')</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content p-3 text-muted">
                                        @if(!empty($locales))
                                            @foreach($locales as $key => $lang)
                                                <div class="tab-pane @if(++$key ==1) active @endif"
                                                     id="editMain{{$value['id']}}{{$lang['code']}}" role="tabpanel">
                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <label class="form-label">@lang('admin.title')
                                                                - {{$lang['code']}}</label>
                                                            <input type="text" class="form-control"
                                                                   name="title[{{$lang['code']}}]"
                                                                   value="{{ !empty($value['title'][$lang['code']])? $value['title'][$lang['code']]: NULL }}">
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label">@lang('admin.unit_of_measure')
                                                                - {{$lang['code']}}</label>
                                                            <input type="text" class="form-control"
                                                                   name="unit_of_measure[{{$lang['code']}}]"
                                                                   value="{{ !empty($value['unit_of_measure'][$lang['code']])? $value['unit_of_measure'][$lang['code']]: NULL }}">
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label">@lang('admin.service_charge')
                                                                - {{$lang['code']}}</label>
                                                            <input type="text" class="form-control"
                                                                   name="service_charge[{{$lang['code']}}]"
                                                                   value="{{ !empty($value['service_charge'][$lang['code']])? $value['service_charge'][$lang['code']]: NULL }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        <div class="tab-pane" id="editMainOther{{$value['id']}}" role="tabpanel">
                                            <div class="row g-3">
                                                <div class="col-md-12">
                                                    <label for="category_id" class="form-label">@lang('admin.category')</label>
                                                    <select class="form-control" name="category_id" id="category_id">
                                                        <option value="">@lang('admin.choose')</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{$category->id}}"  @if(!empty($value['category_id']) && $value['category_id'] == $category['id']) selected @endif>{{ !empty(json_decode($category, true)['title'][$currentLang])? json_decode($category, true)['title'][$currentLang]: null }}</option>
                                                        @endforeach
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
                            <form action="{{ route('admin.tariff.destroy',$value['id']) }}" method="POST">
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
    <script>
        $(document).ready(function () {
            $('#input-tariff').on('change', function () {
                let parentId = $(this).val();
                let subTariffWrapper = $('#sub-tariff-wrapper');
                let subTariffSelect = $('#input-sub-tariff');

                // Əgər parent_id boşdursa, sub_tariff selectini gizlədirik
                if (!parentId) {
                    subTariffWrapper.hide();
                    subTariffSelect.html('<option value="">@lang("admin.choose")</option>');
                    return;
                }

                // AJAX ilə alt kateqoriyaları gətiririk
                $.ajax({
                    url: '{{ route('admin.tariff.getParentTariff') }}', // Bu URL `web.php` faylında göstərilməlidir
                    type: 'GET',
                    data: { tariff_id: parentId },
                    success: function (response) {
                        if (response.success && response.parentTariff.length > 0) {
                            // Alt kateqoriyaları doldur
                            subTariffSelect.html('<option value="">@lang("admin.choose")</option>');
                            $.each(response.parentTariff, function (index, subTariff) {
                                subTariffSelect.append(
                                    `<option value="${subTariff.id}">${subTariff.title}</option>`
                                );
                            });
                            subTariffWrapper.show();
                        } else {
                            // Alt kateqoriya yoxdursa, seçimi gizlət
                            subTariffWrapper.hide();
                            subTariffSelect.html('<option value="">@lang("admin.choose")</option>');
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
