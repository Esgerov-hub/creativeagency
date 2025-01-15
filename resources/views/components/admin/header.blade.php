<div class="header">
    <div class="row g-0 align-items-center">
        <div class="col-xxl-6 col-xl-5 col-4 d-flex align-items-center gap-20">
            <div class="main-logo d-lg-block d-none">
                <div class="logo-big">
                    <a href="{{ route('admin.index') }}">
                        <img src="{{ asset('admin/avatar/logo.png') }}" alt="Logo">
                    </a>
                </div>
                <div class="logo-small">
                    <a href="{{ route('admin.index') }}">
                        <img src="{{ asset('admin/avatar/favicon.png') }}" alt="Logo">
                    </a>
                </div>
            </div>
            <div class="nav-close-btn">
                <button id="navClose"><i class="fa-light fa-bars-sort"></i></button>
            </div>
            <a href="{{ route('site.index') }}" target="_blank" class="btn btn-sm btn-primary site-view-btn"><i class="fa-light fa-globe me-1"></i> <span>@lang('admin.website')</span></a>
        </div>
        <div class="col-xxl-6 col-xl-7 col-lg-8 col-4">
            <div class="header-right-btns d-flex justify-content-end align-items-center">
                <div class="header-btn-box">
                    <button class="header-btn" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ucfirst($data['lang'])}}
                    </button>
                    <ul class="notification-dropdown dropdown-menu" aria-labelledby="notificationDropdown">
                        @foreach($data['langs'] as $localeCode => $properties)
                            @if($properties['code'] != $data['lang'])
                                <li>
                                    <a  class="d-flex align-items-center"  hreflang="{{ $properties['code'] }}"  href="{{ LaravelLocalization::getLocalizedURL($properties['code'], null, [], true) }}">
                                        {{ $properties['name'] }}
                                    </a>
                                </li>
                            @endif
                        @endforeach

                    </ul>
                </div>
                <button class="header-btn header-collapse-group-btn d-lg-none"><i class="fa-light fa-ellipsis-vertical"></i></button>
                <button class="header-btn theme-settings-btn d-lg-none"><i class="fa-light fa-gear"></i></button>
                <div class="header-btn-box profile-btn-box">
                    <button class="profile-btn" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('admin/avatar/avatar.png') }}" alt="image">
                    </button>
                    <ul class="dropdown-menu profile-dropdown-menu">
                        <li>
                            <div class="dropdown-txt text-center">
                                <p class="mb-0">{{ auth('admin')->user()->name }} {{ auth('admin')->user()->surname }}</p>
                                <span class="d-block">{{ auth('admin')->user()->type }}</span>
                            </div>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('admin.cms-users.edit',auth('admin')->user()->id) }}"><span class="dropdown-icon"><i class="fa-regular fa-gear"></i></span> @lang('admin.settings')</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.logout') }}"><span class="dropdown-icon"><i class="fa-regular fa-arrow-right-from-bracket"></i></span> @lang('admin.logout')</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
