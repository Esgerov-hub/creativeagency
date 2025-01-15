@extends('admin.layouts.app')
@section('admin.title')
    @lang('admin.add')
@endsection
@section('admin.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css">
@endsection
@section('admin.content')
    @if ($instituteCategory['page_type'] == 'image_content')
     <div class="main-content">
        <div class="dashboard-breadcrumb mb-25">
            <h2>@lang('admin.add')</h2>
        </div>
        @include('components.admin.error')
        <div class="row">
            <div class="col-12">
                <form action="{{ route('admin.institute.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="category_slug" value="{{ !empty($instituteCategory['slug'][$currentLang]) ? $instituteCategory['slug'][$currentLang]: \Illuminate\Support\Facades\Lang::get('admin.institute') }}">
                    <div class="panel">
                        <div class="panel-body">
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
                                                    <label class="form-label">@lang('admin.full_name') - {{$lang['code']}}</label>
                                                    <input type="text" class="form-control" name="full_name[{{$lang['code']}}]">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">@lang('admin.full_text') - {{$lang['code']}}</label>
                                                    <textarea class="editor form-control"
                                                              data-locale="{{ $lang['code'] }}"
                                                              data-csrf-token="{{ csrf_token() }}"
                                                              name="fulltext[{{$lang['code']}}]"></textarea>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">@lang('admin.reception_days') - {{$lang['code']}}</label>
                                                    <input type="text" class="form-control" name="reception_days[{{$lang['code']}}]">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="tab-pane" id="other" role="tabpanel">

                                    <div class="row g-3">


                                        <div class="col-md-12">
                                            <label class="form-label">@lang('admin.main_image')</label>
                                            <input type="file" name="image" id="mainImageUpload" accept="image/png,jpg">
                                            <div id="mainImagePreview" style="margin-top: 10px;"></div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="input-category" class="form-label">@lang('admin.position')</label>
                                            <select class="form-control" name="position_id" id="input-category">
                                                <option value="">@lang('admin.choose')</option>
                                                @foreach($positions as $position)
                                                    <option value="{{ $position->id }}">
                                                        {{ $position['title'][$currentLang] ?? '' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-12">
                                            <label for="input-parent-category" class="form-label">@lang('admin.parent_position')</label>
                                            <select class="form-control" name="parent_position_id" id="input-parent-category">
                                                <option value="">@lang('admin.choose')</option>
                                                <!-- Options will be populated by JavaScript -->
                                            </select>
                                        </div>

                                        <div class="col-sm-12">
                                            <label class="form-label">@lang('admin.status')</label>
                                            <select class="form-control" name="status">
                                                <option value="1" >@lang('admin.active')</option>
                                                <option value="0" >@lang('admin.nonactive')</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">@lang('admin.save')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @elseif ($instituteCategory['page_type'] == 'content')
     <div class="main-content">
        <div class="dashboard-breadcrumb mb-25">
            <h2>@lang('admin.add')</h2>
        </div>
        @include('components.admin.error')
        <div class="row">
            <div class="col-12">
                <form action="{{ route('admin.institute.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="category_slug" value="{{ !empty($instituteCategory['slug'][$currentLang]) ? $instituteCategory['slug'][$currentLang]: \Illuminate\Support\Facades\Lang::get('admin.institute') }}">
                    <div class="panel">
                        <div class="panel-body">
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
                                                    <label class="form-label">@lang('admin.title') - {{$lang['code']}}</label>
                                                    <input type="text" class="form-control" name="title[{{$lang['code']}}]">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">@lang('admin.full_name') - {{$lang['code']}}</label>
                                                    <input type="text" class="form-control" name="full_name[{{$lang['code']}}]">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">@lang('admin.reception_days') - {{$lang['code']}}</label>
                                                    <input type="text" class="form-control" name="reception_days[{{$lang['code']}}]">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="tab-pane" id="other" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label class="form-label">@lang('admin.file')</label>
                                            <input  class="form-control" type="file" name="file">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">@lang('admin.email')</label>
                                            <input  class="form-control" type="email" name="email">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">@lang('admin.phone')</label>
                                            <input  class="form-control" type="text" name="phone">
                                        </div>
                                        <div class="col-md-12">
                                            <label for="input-category" class="form-label">@lang('admin.position')</label>
                                            <select class="form-control" name="position_id" id="input-category">
                                                <option value="">@lang('admin.choose')</option>
                                                @foreach($positions as $position)
                                                    <option value="{{ $position->id }}">
                                                        {{ $position['title'][$currentLang] ?? '' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-12">
                                            <label for="input-parent-category" class="form-label">@lang('admin.parent_position')</label>
                                            <select class="form-control" name="parent_position_id" id="input-parent-category">
                                                <option value="">@lang('admin.choose')</option>
                                                <!-- Options will be populated by JavaScript -->
                                            </select>
                                        </div>

                                        <div class="col-sm-12">
                                            <label class="form-label">@lang('admin.status')</label>
                                            <select class="form-control" name="status">
                                                <option value="1" >@lang('admin.active')</option>
                                                <option value="0" >@lang('admin.nonactive')</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">@lang('admin.save')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @elseif ($instituteCategory['page_type'] == 'photo')
        <div class="main-content">
            <div class="dashboard-breadcrumb mb-25">
                <h2>@lang('admin.add')</h2>
            </div>
            @include('components.admin.error')
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('admin.institute.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="category_slug" value="{{ !empty($instituteCategory['slug'][$currentLang]) ? $instituteCategory['slug'][$currentLang]: \Illuminate\Support\Facades\Lang::get('admin.institute') }}">
                        <div class="panel">
                            <div class="panel-body">
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
                                                        <label class="form-label">@lang('admin.title') - {{$lang['code']}}</label>
                                                        <input type="text" class="form-control" name="title[{{$lang['code']}}]">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="tab-pane" id="other" role="tabpanel">
                                        <div class="row g-3">
                                            <div class="col-md-12">
                                                <label class="form-label">@lang('admin.main_image')</label>
                                                <input type="file" name="image" id="mainImageUpload" accept="image/png,jpg">
                                                <div id="mainImagePreview" style="margin-top: 10px;"></div>
                                            </div>
                                            <div class="col-sm-12">
                                                <label class="form-label">@lang('admin.status')</label>
                                                <select class="form-control" name="status">
                                                    <option value="1" >@lang('admin.active')</option>
                                                    <option value="0" >@lang('admin.nonactive')</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">@lang('admin.save')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('admin.js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Tek resim için: Dosya adını göster
            document.getElementById('mainImageUpload').addEventListener('change', function(event) {
                const mainImagePreview = document.getElementById('mainImagePreview');
                mainImagePreview.innerHTML = ''; // Önizleme alanını temizle
                const file = event.target.files[0];
                if (file) {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file); // Resmin src'sini ayarla
                    img.style.width = '150px';
                    img.style.height = 'auto';
                    img.style.border = '1px solid #ccc';
                    img.style.padding = '5px';
                    img.style.marginTop = '5px';

                    // Önizleme alanına resmi ekle
                    mainImagePreview.appendChild(img);
                }
            });
        });
    </script>
<script>
    document.getElementById('input-category').addEventListener('change', function () {
        var positionId = this.value;
        var currentLang = "{{ $currentLang }}";
        var parentSelect = document.getElementById('input-parent-category');

        if (positionId) {
            console.log('Fetching parent positions for:', positionId);

            // Add loading indicator
            parentSelect.innerHTML = '<option value="">' + '@lang("admin.loading")' + '...</option>';

            fetch(`/az/admin/parent-positions/${positionId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Parent positions fetched:', data);
                    
                    // Reset dropdown options
                    parentSelect.innerHTML = '<option value="">' + '@lang("admin.choose")' + '</option>';

                    if (data.length > 0) {
                        data.forEach(function (parentPosition) {
                            var option = document.createElement('option');
                            option.value = parentPosition.id;
                            option.text = parentPosition.title?.[currentLang] || 'Unknown Title';
                            parentSelect.appendChild(option);
                        });
                    } else {
                        // If no data, show a message
                        parentSelect.innerHTML = '<option value="">' + '@lang("admin.no_results")' + '</option>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching parent positions:', error);
                    // Display an error message
                    parentSelect.innerHTML = '<option value="">' + '@lang("admin.error_loading")' + '</option>';
                });
        } else {
            // Reset dropdown if no category is selected
            parentSelect.innerHTML = '<option value="">' + '@lang("admin.choose")' + '</option>';
        }
    });
</script>

    <script src="{{ asset('summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('summernote/editor_summernote.js') }}"></script>
@endsection

