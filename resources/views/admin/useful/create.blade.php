@extends('admin.layouts.app')
@section('admin.title')
    @lang('admin.edit')
@endsection
@section('admin.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css">
@endsection
@section('admin.content')
    <div class="main-content">
        <div class="dashboard-breadcrumb mb-25">
            <h2>@lang('admin.add')</h2>
        </div>
        @include('components.admin.error')
        <div class="row">
            <div class="col-12">
                <form action="{{ route('admin.useful.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
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
                                                    <label class="form-label">@lang('admin.text') - {{$lang['code']}}</label>
                                                    <textarea class="form-control" type="text" name="text[{{$lang['code']}}]" ></textarea>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">@lang('admin.full_text') - {{$lang['code']}}</label>
                                                    <textarea class="editor form-control"
                                                              data-locale="{{ $lang['code'] }}"
                                                              data-csrf-token="{{ csrf_token() }}"
                                                              name="fulltext[{{$lang['code']}}]"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="tab-pane" id="other" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label for="category_id" class="form-label">@lang('admin.main_category')</label>
                                            <select class="form-control" name="category_id" id="category_id">
                                                <option value="">@lang('admin.choose')</option>
                                                @foreach($mainUsefulCategories as $category)
                                                    <option value="{{ $category->id }}">
                                                        {{ json_decode($category, true)['title'][$currentLang] ?? null }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4" id="parent-category-wrapper" style="display: none;">
                                            <label for="parent_id" class="form-label">@lang('admin.parent_category')</label>
                                            <select class="form-control" name="parent_id" id="parent_id">
                                                <option value="">@lang('admin.choose')</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4" id="sub-parent-category-wrapper" style="display: none;">
                                            <label for="sub_parent_id" class="form-label">@lang('admin.sub_category')</label>
                                            <select class="form-control" name="sub_parent_id" id="sub_parent_id">
                                                <option value="">@lang('admin.choose')</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-label">@lang('admin.status')</label>
                                            <select class="form-control" name="status">
                                                <option value="1" >@lang('admin.active')</option>
                                                <option value="0" >@lang('admin.nonactive')</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-label">@lang('admin.datetime')</label>
                                            <input type="datetime-local" class="form-control" name="datetime">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">@lang('admin.file')</label>
                                            <input  class="form-control" type="file" name="file">
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="col-lg-8 col-md-7">
                                                <div class="card component-jquery-uploader">
                                                    <div class="card-header">
                                                        @lang('admin.images')
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-xxl-9 col-sm-8">
                                                                <label class="form-label">@lang('admin.main_image')</label>
                                                                <input type="file" name="image" id="mainImageUpload">
                                                                <div id="mainImagePreview" style="margin-top: 10px;"></div>
                                                            </div>
                                                            <div class="col-xxl-9 col-sm-8">
                                                                <label class="form-label">@lang('admin.slider_image')</label>
                                                                <input type="file" id="multipleUpload" name="slider_image[]" multiple>
                                                                <div id="sliderImagePreview" style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
@endsection
@section('admin.js')
    <script>
        $(document).ready(function () {
            // Main Category seçildikdə
            $('#category_id').on('change', function () {
                let categoryId = $(this).val();
                let parentWrapper = $('#parent-category-wrapper');
                let parentSelect = $('#parent_id');
                let subParentWrapper = $('#sub-parent-category-wrapper');
                let subParentSelect = $('#sub_parent_id');

                // Seçim boşdursa
                if (!categoryId) {
                    parentWrapper.hide();
                    subParentWrapper.hide();
                    parentSelect.html('<option value="">@lang("admin.choose")</option>');
                    subParentSelect.html('<option value="">@lang("admin.choose")</option>');
                    return;
                }

                // AJAX ilə parent kateqoriyaları əldə et
                $.ajax({
                    url: '{{ route('admin.useful-categories.getParentCategories') }}',
                    type: 'GET',
                    data: { category_id: categoryId },
                    success: function (response) {
                        if (response.success && response.parentCategories.length > 0) {
                            parentSelect.html('<option value="">@lang("admin.choose")</option>');
                            $.each(response.parentCategories, function (index, parent) {
                                parentSelect.append(
                                    `<option value="${parent.id}">${parent.title}</option>`
                                );
                            });
                            parentWrapper.show();
                        } else {
                            parentWrapper.hide();
                            subParentWrapper.hide();
                            parentSelect.html('<option value="">@lang("admin.choose")</option>');
                            subParentSelect.html('<option value="">@lang("admin.choose")</option>');
                        }
                    },
                    error: function () {
                        alert('@lang("admin.error_loading_categories")');
                    }
                });
            });

            // Parent Category seçildikdə
            $('#parent_id').on('change', function () {
                let parentId = $(this).val();
                let subParentWrapper = $('#sub-parent-category-wrapper');
                let subParentSelect = $('#sub_parent_id');
                if (!parentId) {
                    subParentWrapper.hide();
                    subParentSelect.html('<option value="">@lang("admin.choose")</option>');
                    return;
                }
                // AJAX ilə sub-parent kateqoriyaları əldə et
                $.ajax({
                    url: '{{ route('admin.useful-categories.getSubParentCategories') }}',
                    type: 'GET',
                    data: { parent_id: parentId },
                    success: function (response) {
                        if (response.success && response.subParentCategories.length > 0) {
                            subParentSelect.html('<option value="">@lang("admin.choose")</option>');
                            $.each(response.subParentCategories, function (index, subParent) {
                                subParentSelect.append(
                                    `<option value="${subParent.id}">${subParent.title}</option>`
                                );
                            });
                            subParentWrapper.show();
                        } else {
                            subParentWrapper.hide();
                            subParentSelect.html('<option value="">@lang("admin.choose")</option>');
                        }
                    },
                    error: function () {
                        alert('@lang("admin.error_loading_categories")');
                    }
                });
            });
        });
    </script>
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

            // Çoklu resim için: Sadece resim önizlemelerini göster
            document.getElementById('multipleUpload').addEventListener('change', function(event) {
                const sliderImagePreview = document.getElementById('sliderImagePreview');
                sliderImagePreview.innerHTML = '';
                Array.from(event.target.files).forEach((file, index) => {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.style.width = '100px';
                    img.style.height = 'auto';
                    img.style.border = '1px solid #ccc';
                    img.style.padding = '5px';
                    img.style.marginRight = '5px';

                    // Önizleme alanına ekle
                    sliderImagePreview.appendChild(img);
                });
            });
        });
    </script>
    <script src="{{ asset('summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('summernote/editor_summernote.js') }}"></script>
@endsection
