@extends('admin.layouts.app')
@section('admin.title')
    {{ !empty($instituteCategory['title'][$currentLang]) ? $instituteCategory['title'][$currentLang]: \Illuminate\Support\Facades\Lang::get('admin.institute') }}
@endsection
@section('admin.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css">
    @if ($instituteCategory['page_type'] == 'slide_content')
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/swiper-bundle.min.css') }}">
    @elseif ($instituteCategory['page_type'] == 'file_content')
    @elseif ($instituteCategory['page_type'] == 'image_content')
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/aos.css') }}">
    @endif
@endsection
@section('admin.content')
    @if ($instituteCategory['page_type'] == 'slide_content')
        <div class="main-content">
            <div class="dashboard-breadcrumb mb-25">
                <h2>{{ !empty($instituteCategory['title'][$currentLang]) ? $instituteCategory['title'][$currentLang]: \Illuminate\Support\Facades\Lang::get('admin.institute') }}</h2>
            </div>
            @include('components.admin.error')
            <div class="row">
                <div class="col-12">
                    <form action=" @if(!empty($institutePage['id'])) {{ route('admin.institute.update',$institutePage['id']) }} @else{{ route('admin.institute.store') }}@endif" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(!empty($institutePage['id']))
                            @method('PUT')
                        @endif
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
                                                        <input type="text" class="form-control" name="title[{{$lang['code']}}]" value="{{ !empty($institutePage['title'][$lang['code']])? $institutePage['title'][$lang['code']]: NULL }}">
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label">@lang('admin.text') - {{$lang['code']}}</label>
                                                        <textarea class="form-control" type="text" name="text[{{$lang['code']}}]" >{{ !empty($institutePage['text'][$lang['code']])? $institutePage['text'][$lang['code']]: NULL }}</textarea>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label">@lang('admin.full_text') - {{$lang['code']}}</label>
                                                        <textarea class="editor form-control" data-locale="{{ $lang['code'] }}" data-csrf-token="{{ csrf_token() }}" name="fulltext[{{$lang['code']}}]">{{ !empty($institutePage['fulltext'][$lang['code']])? $institutePage['fulltext'][$lang['code']]: NULL }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="tab-pane" id="other" role="tabpanel">
                                        <div class="row g-3">
                                            <div class="col-sm-12">

                                                <div class="col-lg-8 col-md-7">
                                                    <div class="card component-jquery-uploader">
                                                        <div class="card-header">
                                                            @lang('admin.images')
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
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
                                            @if(!empty($institutePage['slider_image']))
                                                <div class="col-md-5">
                                                    <div class="slider-images" style="display: flex; flex-wrap: wrap; gap: 10px;"> <!-- Flex container -->
                                                        @foreach($institutePage['slider_image'] as $slider_image)
                                                            <div style="flex: 0 0 30%;"> <!-- Her resmin genişliği %30 -->
                                                                <img src="{{ asset('uploads/institute/abouts/'.$slider_image) }}" style="width:100%; height: auto; padding: 10px!important;">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
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
    @elseif ($instituteCategory['page_type'] == 'file_content')
        <div class="main-content">
            <div class="dashboard-breadcrumb mb-25">
                <h2>{{ !empty($instituteCategory['title'][$currentLang]) ? $instituteCategory['title'][$currentLang]: \Illuminate\Support\Facades\Lang::get('admin.institute') }}</h2>
            </div>
            @include('components.admin.error')
            <div class="row">
                <div class="col-12">
                    <form action=" @if(!empty($institutePage['id'])) {{ route('admin.institute.update',$institutePage['id']) }} @else{{ route('admin.institute.store') }}@endif" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(!empty($institutePage['id']))
                            @method('PUT')
                        @endif
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
                                                        <input type="text" class="form-control" name="title[{{$lang['code']}}]" value="{{ !empty($institutePage['title'][$lang['code']])? $institutePage['title'][$lang['code']]: NULL }}">
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label">@lang('admin.text') - {{$lang['code']}}</label>
                                                        <textarea class="form-control" type="text" name="text[{{$lang['code']}}]" >{{ !empty($institutePage['text'][$lang['code']])? $institutePage['text'][$lang['code']]: NULL }}</textarea>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label">@lang('admin.full_text') - {{$lang['code']}}</label>
                                                        <textarea class="editor form-control" data-locale="{{ $lang['code'] }}" data-csrf-token="{{ csrf_token() }}" name="fulltext[{{$lang['code']}}]">{{ !empty($institutePage['fulltext'][$lang['code']])? $institutePage['fulltext'][$lang['code']]: NULL }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="tab-pane" id="other" role="tabpanel">
                                        <div class="row g-3">
                                            <div class="col-sm-12">
                                                <div class="col-lg-8 col-md-7">
                                                    <label class="form-label">@lang('admin.file')</label>
                                                    <input type="file" name="file" multiple>
                                                    <div id="sliderImagePreview" style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px;"></div>
                                                </div>
                                            </div>
                                            @if(!empty($institutePage['file']))
                                                <div class="col-md-5">
                                                   <a href="{{ asset('uploads/institute/charter/'.$institutePage['file'] ) }}" target="_blank">Fayl aç</a>
                                                </div>
                                            @endif
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
    @elseif ($instituteCategory['page_type'] == 'image_content')
        <?php $instituteCategorySlug = !empty($instituteCategory['slug'][$currentLang]) ? $instituteCategory['slug'][$currentLang]: \Illuminate\Support\Facades\Lang::get('admin.institute') ?>
        <div class="main-content">
            <div class="dashboard-breadcrumb mb-25">
                <h2>{{ !empty($instituteCategory['title'][$currentLang]) ? $instituteCategory['title'][$currentLang]: \Illuminate\Support\Facades\Lang::get('admin.institute') }}</h2>
                <a class="btn btn-sm btn-primary" href="{{ route('admin.institute.create',$instituteCategorySlug) }}">
                    <i class="fa-light fa-plus"></i> @lang('admin.add')
                </a>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="panel">
                        <div class="panel-body">
                            @if(!empty($institutePage[0]) && isset($institutePage[0]))
                                @foreach($institutePage as $institute)
                                    <h3>{{ $institute['title'][$currentLang] }}</h3>
                                    <div class="row">
                                        @foreach($institute['leadership'] as $data)
                                        <div class="col-sm-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    {{ !empty($data['full_name'][$currentLang])? $data['full_name'][$currentLang]: null }}
                                                    <a href="{{ route('admin.institute.edit',['id'=>$data['id'],'slug'=>$instituteCategorySlug]) }}" class="btn btn-sm btn-icon btn-primary" title="@lang('admin.edit')">
                                                        <i class="fa-light fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-icon btn-danger" data-bs-toggle="modal" data-bs-target="#delete{{$data['id']}}">
                                                        <i class="fa-light fa-trash-can"></i>
                                                    </button>
                                                </div>
                                                <div class="card-body animation-card">
                                                    <div class="text-center" data-aos="flip-left">
                                                        <img src="{{ asset('uploads/institute/leadership/'.$data->image) }}" alt="{{ !empty($data['full_name'][$currentLang])? $data['full_name'][$currentLang]: null }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main content end -->
        @if(!empty($institutePage[0]) && isset($institutePage[0]))
            @foreach($institutePage as $value)
                @foreach($value['leadership'] as $delData)
                <div class="modal fade" id="delete{{$delData['id']}}" tabindex="-1" aria-labelledby="deletecategory{{$delData['id']}}Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title" id="deletecategory{{$delData['id']}}Label">@lang('admin.delete')</h2>
                                <button type="button" class="btn btn-sm btn-icon btn-outline-primary" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fa-light fa-times"></i>
                                </button>
                            </div>
                            <form action="{{ route('admin.institute.destroy',$delData['id']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="category_slug" value="{{ !empty($instituteCategory['slug'][$currentLang]) ? $instituteCategory['slug'][$currentLang]: \Illuminate\Support\Facades\Lang::get('admin.institute') }}">
                                <div class="modal-body">
                                    <h2>@lang('admin.delete_about') </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">@lang('admin.not')</button>
                                    <button type="submit" class="btn btn-sm btn-primary">@lang('admin.yes')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            @endforeach
        @endif
    @elseif ($instituteCategory['page_type'] == 'content')
        <?php $instituteCategorySlug = !empty($instituteCategory['slug'][$currentLang]) ? $instituteCategory['slug'][$currentLang]: \Illuminate\Support\Facades\Lang::get('admin.institute') ?>
        <div class="main-content">
            <div class="dashboard-breadcrumb mb-25">
                <h2>{{ !empty($instituteCategory['title'][$currentLang]) ? $instituteCategory['title'][$currentLang]: \Illuminate\Support\Facades\Lang::get('admin.institute') }}</h2>
                <a class="btn btn-sm btn-primary" href="{{ route('admin.institute.create',$instituteCategorySlug) }}">
                    <i class="fa-light fa-plus"></i> @lang('admin.add')
                </a>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="panel">
                        <div class="panel-body">
                            @if(!empty($institutePage[0]) && isset($institutePage[0]))
                                <div class="row">
                                    @foreach($institutePage as $institute)
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-header">
                                                {{ !empty($institute['full_name'][$currentLang])? $institute['full_name'][$currentLang]: null }}
                                                <a href="{{ route('admin.institute.edit',['id'=>$institute['id'],'slug'=>$instituteCategorySlug]) }}" class="btn btn-sm btn-icon btn-primary" title="@lang('admin.edit')">
                                                    <i class="fa-light fa-edit"></i>
                                                </a>
                                                <button class="btn btn-sm btn-icon btn-danger" data-bs-toggle="modal" data-bs-target="#delete{{$institute['id']}}">
                                                    <i class="fa-light fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main content end -->
        @if(!empty($institutePage[0]) && isset($institutePage[0]))
            @foreach($institutePage as $delData)
                <div class="modal fade" id="delete{{$delData['id']}}" tabindex="-1" aria-labelledby="deletecategory{{$delData['id']}}Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title" id="deletecategory{{$delData['id']}}Label">@lang('admin.delete')</h2>
                                <button type="button" class="btn btn-sm btn-icon btn-outline-primary" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fa-light fa-times"></i>
                                </button>
                            </div>
                            <form action="{{ route('admin.institute.destroy',$delData['id']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="category_slug" value="{{ !empty($instituteCategory['slug'][$currentLang]) ? $instituteCategory['slug'][$currentLang]: \Illuminate\Support\Facades\Lang::get('admin.institute') }}">
                                <div class="modal-body">
                                    <h2>@lang('admin.delete_about') </div>
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
    @elseif ($instituteCategory['page_type'] == 'photo')
        <?php $instituteCategorySlug = !empty($instituteCategory['slug'][$currentLang]) ? $instituteCategory['slug'][$currentLang]: \Illuminate\Support\Facades\Lang::get('admin.institute') ?>
        <div class="main-content">
            <div class="dashboard-breadcrumb mb-25">
                <h2>{{ !empty($instituteCategory['title'][$currentLang]) ? $instituteCategory['title'][$currentLang]: \Illuminate\Support\Facades\Lang::get('admin.institute') }}</h2>
                <a class="btn btn-sm btn-primary" href="{{ route('admin.institute.create',$instituteCategorySlug) }}">
                    <i class="fa-light fa-plus"></i> @lang('admin.add')
                </a>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="panel">
                        <div class="panel-body">
                            @if(!empty($institutePage[0]) && isset($institutePage[0]))
                                <div class="row">
                                    @foreach($institutePage as $data)
                                        <div class="col-sm-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    {{ !empty($data['title'][$currentLang])? $data['title'][$currentLang]: null }}
                                                    <a href="{{ route('admin.institute.edit',['id'=>$data['id'],'slug'=>$instituteCategorySlug]) }}" class="btn btn-sm btn-icon btn-primary" title="@lang('admin.edit')">
                                                        <i class="fa-light fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-icon btn-danger" data-bs-toggle="modal" data-bs-target="#delete{{$data['id']}}">
                                                        <i class="fa-light fa-trash-can"></i>
                                                    </button>
                                                </div>
                                                <div class="card-body animation-card">
                                                    <div class="text-center" data-aos="flip-left">
                                                        <img src="{{ asset('uploads/institute/accreditation/'.$data->image) }}" alt="{{ !empty($data['full_name'][$currentLang])? $data['full_name'][$currentLang]: null }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main content end -->
        @if(!empty($institutePage[0]) && isset($institutePage[0]))
            @foreach($institutePage as $delData)
                <div class="modal fade" id="delete{{$delData['id']}}" tabindex="-1" aria-labelledby="deletecategory{{$delData['id']}}Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title" id="deletecategory{{$delData['id']}}Label">@lang('admin.delete')</h2>
                                <button type="button" class="btn btn-sm btn-icon btn-outline-primary" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fa-light fa-times"></i>
                                </button>
                            </div>
                            <form action="{{ route('admin.institute.destroy',$delData['id']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="category_slug" value="{{ !empty($instituteCategory['slug'][$currentLang]) ? $instituteCategory['slug'][$currentLang]: \Illuminate\Support\Facades\Lang::get('admin.institute') }}">
                                <div class="modal-body">
                                    <h2>@lang('admin.delete_about') </div>
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
    @endif
@endsection
@section('admin.js')
    @if ($instituteCategory['page_type'] == 'slide_content')
        <script>
            let currentSlide = 0;

            function showSlide(slideIndex) {
                const slides = document.getElementById('slides');
                const totalSlides = slides.children.length;

                // Slide dizilimini değiştir
                if (slideIndex >= totalSlides) {
                    currentSlide = 0; // İlk slide'a döner
                } else if (slideIndex < 0) {
                    currentSlide = totalSlides - 1; // Son slide'a döner
                } else {
                    currentSlide = slideIndex;
                }

                // Slide'ları kaydır
                const offset = -currentSlide * 100; // Offset hesapla
                slides.style.transform = `translateX(${offset}%)`;
            }

            // Slide'ları değiştir
            function changeSlide(n) {
                showSlide(currentSlide + n);
            }

            // İlk slide'ı göster
            showSlide(currentSlide);
        </script>
        <script src="{{ asset('admin/assets/vendor/js/swiper-bundle.min.js') }}"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
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
    @elseif ($instituteCategory['page_type'] == 'file_content')
    @elseif ($instituteCategory['page_type'] == 'image_content')
        <script src="{{ asset('admin/assets/vendor/js/aos.js') }}"></script>
    @endif
    <script src="{{ asset('summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('summernote/editor_summernote.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.summernote-height').summernote({
                airMode: true, // Eğer airMode kullanılıyorsa
                disableResizeEditor: true,
                toolbar: false, // Eğer toolbar varsa, kapat
                disableDragAndDrop: true,
                callbacks: {
                    onInit: function() {
                        // Editoru deaktiv et
                        $(this).summernote('disable');
                    }
                }
            });
        });

    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var errorDiv = document.getElementById('error-message');
                if (errorDiv) {
                    errorDiv.style.display = 'none';
                }
            }, 2000);
        });
    </script>
@endsection

