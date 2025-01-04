@extends('admin.layouts.app')
@section('admin.title')
    @lang('admin.services')
@endsection
@section('admin.css')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/jquery.uploader.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/aos.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('admin.content')

    <!-- main content start -->
    <div class="main-content">
        <div class="dashboard-breadcrumb mb-25">
            <h2>@lang('admin.services')</h2>
            @can('services-create')
            <a class="btn btn-sm btn-primary" href="{{ route('admin.service.create') }}">
                <i class="fa-light fa-plus"></i> @lang('admin.add')
            </a>
            @endcan
        </div>
        <div class="row">
            <div class="col-12">
                <div class="panel">
                    <div class="panel-body">
                        <div class="row" id="sortable">
                            @if(!empty($services[0]) && isset($services[0]))
                                @foreach($services as $data)
                                    <div class="col-sm-6" data-id="{{ $data['id'] }}">
                                        <div class="card">
                                            <div class="card-header">
                                                {{ !empty($data['title'][$currentLang])? $data['title'][$currentLang]: null }}
                                                @can('services-edit')
                                                    <a href="{{ route('admin.service.edit',$data['id']) }}" class="btn btn-sm btn-icon btn-primary" title="@lang('admin.edit')">
                                                        <i class="fa-light fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('services-delete')
                                                    <button class="btn btn-sm btn-icon btn-danger" data-bs-toggle="modal" data-bs-target="#delete{{$data['id']}}">
                                                        <i class="fa-light fa-trash-can"></i>
                                                    </button>
                                                @endcan
                                            </div>
                                            <div class="card-body animation-card">
                                                <div class="text-center" data-aos="flip-left">
                                                    <img src="{{ asset('uploads/services/'.$data->image) }}" alt="{{ !empty($data['title'][$currentLang])? $data['title'][$currentLang]: null }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- main content end -->
    @if(!empty($services[0]) && isset($services[0]))
        @foreach($services as $value)
            <div class="modal fade" id="delete{{$value['id']}}" tabindex="-1" aria-labelledby="deletecategory{{$value['id']}}Label" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title" id="deletecategory{{$value['id']}}Label">@lang('admin.delete')</h2>
                            <button type="button" class="btn btn-sm btn-icon btn-outline-primary" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa-light fa-times"></i>
                            </button>
                        </div>
                        <form action="{{ route('admin.service.destroy',$value['id']) }}" method="POST">
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
    <!-- jQuery Kitabxanası -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script>
        $(function () {
            $('#sortable').sortable({
                update: function (event, ui) {
                    let sortedIDs = $(this).sortable('toArray', { attribute: 'data-id' });

                    // AJAX vasitəsilə məlumat göndər
                    $.ajax({
                        url: "{{ route('admin.services.orderBy') }}",
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            sortedIDs: sortedIDs
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                alert('Sıralama uğurla yeniləndi!');
                            } else {
                                alert('Xəta baş verdi, yenidən cəhd edin.');
                            }
                        }
                    });
                }
            });
        });
    </script>
    <script src="{{ asset('admin/assets/vendor/js/jquery.uploader.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/category.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/js/aos.js') }}"></script>
@endsection
