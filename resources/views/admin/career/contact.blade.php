@extends('admin.layouts.app')
@section('admin.title')
    @lang('admin.career_contact')
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
                        <h5>@lang('admin.career_contact')</h5>
                    </div>
                    <div class="panel-body">
                        <table class="table table-dashed table-hover digi-dataTable task-table table-striped"
                               id="taskTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('admin.full_name')</th>
                                <th>@lang('admin.Email')</th>
                                <th>@lang('admin.phone')</th>
                                <th>Tarix</th>
                                <th>@lang('admin.settings')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($careerContact[0]) && isset($careerContact[0]))
                                @foreach($careerContact as $data)
                                    <tr>
                                        <td>{{ $data['id'] }}</td>
                                        <td>{!! $data['name'] !!} {!! $data['surname'] !!} {!! $data['father_name'] !!}</td>
                                        <td>{!! $data['email'] !!}</td>
                                        <td>{!! $data['phone'] !!}</td>
                                        <td>{{ date('Y-m-d H:i:s',strtotime($data['datetime'])) }}</td>
                                        <td>
                                            <div class="btn-box">
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
    @if(!empty($careerContact[0]) && isset($careerContact[0]))
        @foreach($careerContact as $value)
            <!-- edit task modal -->
            <div class="modal fade" id="editTaskModal{{$value['id']}}" tabindex="-1"
                 aria-labelledby="editTaskModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                            <div class="modal-body">
                                <ul class="nav nav-pills nav-justified" role="tablist">
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link active" data-bs-toggle="tab"
                                           href="#stepone{{$value['id']}}" role="tab">
                                            <span class="d-none d-sm-block">@lang('admin.about_your')</span>
                                        </a>
                                    </li> <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link" data-bs-toggle="tab"
                                           href="#steptwo{{$value['id']}}" role="tab">
                                            <span class="d-none d-sm-block">@lang('admin.education')</span>
                                        </a>
                                    </li> <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link" data-bs-toggle="tab"
                                           href="#steptree{{$value['id']}}" role="tab">
                                            <span class="d-none d-sm-block">@lang('admin.work')</span>
                                        </a>
                                    </li> <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link" data-bs-toggle="tab"
                                           href="#stepfoer{{$value['id']}}" role="tab">
                                            <span class="d-none d-sm-block">@lang('admin.lang_skill')</span>
                                        </a>
                                    </li> <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link" data-bs-toggle="tab"
                                           href="#stepfive{{$value['id']}}" role="tab">
                                            <span class="d-none d-sm-block">@lang('admin.other')</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content p-3 text-muted">
                                    <div class="tab-pane active" id="stepone{{$value['id']}}" role="tabpanel">
                                        <table class="table table-dashed table-hover digi-dataTable task-table table-striped">
                                            <thead>
                                            <tr>
                                                <th>@lang('admin.full_name')</th>
                                                <th>@lang('admin.Email')</th>
                                                <th>@lang('admin.phone')</th>
                                                <th>@lang('admin.address')</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td> {{ $value['surname'] }} {{ $value['name'] }}  {{ $value['father_name'] }}</td>
                                                    <td>{{ $value['email'] }}</td>
                                                    <td>{{ $value['phone'] }}</td>
                                                    <td>{{ $value['address'] }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="steptwo{{$value['id']}}" role="tabpanel">
                                        <table class="table table-dashed table-hover digi-dataTable task-table table-striped">
                                            <thead>
                                            <tr>

                                                <th>@lang('admin.education_org')</th>
                                                <th>@lang('admin.start_date')</th>
                                                <th>@lang('admin.end_date')</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(!empty(json_decode($data['education'],true)[0]))
                                                @foreach(json_decode($data['education'],true) as $education)
                                                    <tr>
                                                        <td> {{ $education['education_org'] }}</td>
                                                        <td>{{ $education['start_date'] }}</td>
                                                        <td>{{ $education['end_date'] }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="steptree{{$value['id']}}" role="tabpanel">
                                        <table class="table table-dashed table-hover digi-dataTable task-table table-striped">
                                            <thead>
                                            <tr>

                                                <th>@lang('admin.institution_org')</th>
                                                <th>@lang('admin.position')</th>
                                                <th>@lang('admin.start_date')</th>
                                                <th>@lang('admin.end_date')</th>
                                                <th>@lang('admin.leaving_reason')</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(!empty(json_decode($data['experience'],true)[0]))
                                                @foreach(json_decode($data['experience'],true) as $experience)
                                                    <tr>
                                                        <td> {{ $experience['institution_org'] }}</td>
                                                        <td>{{ $experience['position'] }}</td>
                                                        <td>{{ $experience['start_date'] }}</td>
                                                        <td>{{ $experience['end_date'] }}</td>
                                                        <td>{{ $experience['leaving_reason'] }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="stepfoer{{$value['id']}}" role="tabpanel">
                                        <div class="language-form">
                                            @if(!empty(json_decode($data['language'],true)))
                                                @foreach(json_decode($data['language'],true) as $langKey => $language)
                                                <div class="language-row">
                                                    <label for="{{$langKey}}">{{ ucfirst($langKey) }}</label>
                                                    <div class="radio-group">
                                                        <label id="excellent">
                                                            <input type="radio" name="{{$langKey}}" value="Əla" @if($language === "Əla") checked @endif />
                                                            <span></span>
                                                        </label>
                                                        <label id="good">
                                                            <input type="radio" name="{{$langKey}}" value="Yaxşı" @if($language === "Yaxşı") checked @endif />
                                                            <span></span>
                                                        </label>
                                                        <label id="poor">
                                                            <input type="radio" name="{{$langKey}}" value="Zəif" @if($language === "Zəif") checked @endif />
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="stepfive{{$value['id']}}" role="tabpanel">
                                        <div class="row g-3">
                                            <div class="col-md-5">
                                                <img src="{{ asset('uploads/careerApply/photo/'.$value->image) }}" style="width: 288px;!important;">
                                            </div>
                                            <div class="col-md-5">
                                                <a href="{{ asset('uploads/careerApply/cv/'.$value->resume) }}" target="_blank">CV</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">@lang('admin.close')</button>
                            </div>
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
                        <form action="{{ route('admin.career.contactDestroy',$value['id']) }}" method="POST">
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
