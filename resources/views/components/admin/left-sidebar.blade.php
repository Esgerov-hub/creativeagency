<div class="main-sidebar">
    <div class="main-menu">
        <ul class="sidebar-menu scrollable">
            @can('dashboards-view')
            <li class="sidebar-item">
                <a href="{{ route('admin.index') }}" class="sidebar-link-group-title  {{ Route::currentRouteName() === 'admin.index' ? 'active' : '' }}">@lang('admin.dashboards')</a>
            </li>
            @endcan

            <li class="sidebar-item">
                <a role="button" class="sidebar-link-group-title has-sub">@lang('admin.main_page')</a>
                <ul class="sidebar-link-group" @if(in_array(Route::currentRouteName(),['admin.sliders.index', 'admin.useful-link.index'])) style="display: block;!important;" @else style="display: none;!important;" @endif>
                    @can('sliders-view')
                        <li class="sidebar-dropdown-item">
                            <a href="{{ route('admin.sliders.index') }}" class="sidebar-link">
                            <span class="nav-icon">
                                <i class="fa-light fa-filter-list"></i>
                            </span>
                                <span class="sidebar-txt">@lang('admin.slider')</span>
                            </a>
                        </li>
                    @endcan
                    @can('enlightenment-view')
                        <li class="sidebar-dropdown-item">
                            <a href="{{ route('admin.enlightenment.index') }}" class="sidebar-link">
                            <span class="nav-icon">
                                <i class="fa-light fa-filter-list"></i>
                            </span>
                                <span class="sidebar-txt">@lang('admin.enlightenment')</span>
                            </a>
                        </li>
                    @endcan
                    @can('tariff-view')
                        <li class="sidebar-dropdown-item">
                            <a href="{{ route('admin.tariff-category.index') }}" class="sidebar-link">
                            <span class="nav-icon">
                                <i class="fa-light fa-filter-list"></i>
                            </span>
                                <span class="sidebar-txt">@lang('admin.tariff_category')</span>
                            </a>
                        </li>
                        <li class="sidebar-dropdown-item">
                            <a href="{{ route('admin.tariff.index') }}" class="sidebar-link">
                            <span class="nav-icon">
                                <i class="fa-light fa-filter-list"></i>
                            </span>
                                <span class="sidebar-txt">@lang('admin.tariff')</span>
                            </a>
                        </li>
                    @endcan
                    {{-- @can('healthy-eating-view')
                        <li class="sidebar-dropdown-item">
                            <a href="{{ route('admin.healthy-eating.index') }}" class="sidebar-link">
                            <span class="nav-icon">
                                <i class="fa-light fa-filter-list"></i>
                            </span>
                                <span class="sidebar-txt">@lang('admin.healthy_eating')</span>
                            </a>
                        </li>
                    @endcan --}}
                    @can('useful-link-view')
                        <li class="sidebar-dropdown-item">
                            <a href="{{ route('admin.useful-link.index') }}" class="sidebar-link">
                            <span class="nav-icon">
                                <i class="fa-light fa-filter-list"></i>
                            </span>
                                <span class="sidebar-txt">@lang('admin.useful_links')</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            <li class="sidebar-item">
                <a role="button" class="sidebar-link-group-title has-sub">@lang('admin.institute')</a>
                <ul class="sidebar-link-group" @if(in_array(Route::currentRouteName(),['admin.institute-categories.index','admin.positions.index','admin.institute.index'])) style="display: block;!important;" @else style="display: none;!important;" @endif>
                    @can('institute-categories-view')
                        <li class="sidebar-dropdown-item">
                            <a href="{{ route('admin.institute-categories.index') }}" class="sidebar-link">
                            <span class="nav-icon">
                                <i class="fa-light fa-filter-list"></i>
                            </span>
                                <span class="sidebar-txt">@lang('admin.institute_categories')</span>
                            </a>
                        </li>
                    @endcan
                    @can('positions-view')
                        <li class="sidebar-dropdown-item">
                            <a href="{{ route('admin.positions.index') }}" class="sidebar-link">
                            <span class="nav-icon">
                                <i class="fa-light fa-filter-list"></i>
                            </span>
                                <span class="sidebar-txt">@lang('admin.positions')</span>
                            </a>
                        </li>
                    @endcan
                    @can('institute-view')
                        @if(!empty($instituteCategory[0]))
                            @foreach($instituteCategory as $institute)
                                <li class="sidebar-dropdown-item">
                                    <a href="{{ route('admin.institute.index',$institute['slug'][$currentLang]) }}" class="sidebar-link">
                                    <span class="nav-icon">
                                        <i class="fa-light fa-filter-list"></i>
                                    </span>
                                        <span class="sidebar-txt">{{$institute['title'][$currentLang]}}</span>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    @endcan
                </ul>
            </li>
            {{-- <li class="sidebar-item">
                <a role="button" class="sidebar-link-group-title has-sub">@lang('admin.laboratory')</a>
                <ul class="sidebar-link-group" @if(in_array(Route::currentRouteName(),['admin.city.index'])) style="display: block;!important;" @else style="display: none;!important;" @endif>
                    @can('city-view')
                        <li class="sidebar-dropdown-item">
                            <a href="{{ route('admin.city.index') }}" class="sidebar-link">
                            <span class="nav-icon">
                                <i class="fa-light fa-filter-list"></i>
                            </span>
                                <span class="sidebar-txt">@lang('admin.cities')</span>
                            </a>
                        </li>
                    @endcan
                    @can('laboratory-category-view')
                        <li class="sidebar-dropdown-item">
                            <a href="{{ route('admin.laboratory-category.index') }}" class="sidebar-link">
                            <span class="nav-icon">
                                <i class="fa-light fa-filter-list"></i>
                            </span>
                                <span class="sidebar-txt">@lang('admin.categories')</span>
                            </a>
                        </li>
                    @endcan
                    @can('laboratory-view')
                        <li class="sidebar-dropdown-item">
                            <a href="{{ route('admin.laboratory.index') }}" class="sidebar-link">
                            <span class="nav-icon">
                                <i class="fa-light fa-filter-list"></i>
                            </span>
                                <span class="sidebar-txt">@lang('admin.laboratory')</span>
                            </a>
                        </li>
                        <li class="sidebar-dropdown-item">
                            <a href="{{ route('admin.virtual-laboratory.index') }}" class="sidebar-link">
                            <span class="nav-icon">
                                <i class="fa-light fa-filter-list"></i>
                            </span>
                                <span class="sidebar-txt">@lang('admin.virtual_laboratory')</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li> --}}
            @can('services-view')
                <li class="sidebar-item">
                    <a href="{{ route('admin.service.index') }}" class="sidebar-link-group-title  {{ Route::currentRouteName() === 'admin.service.index' ? 'active' : '' }}">@lang('admin.services')</a>
                </li>
            @endcan
            <li class="sidebar-item">
                <a role="button" class="sidebar-link-group-title has-sub">@lang('admin.useful')</a>
                <ul class="sidebar-link-group" @if(in_array(Route::currentRouteName(),['admin.useful-categories.index'])) style="display: block;!important;" @else style="display: none;!important;" @endif>
                    @can('useful-categories-view')
                        <li class="sidebar-dropdown-item">
                            <a href="{{ route('admin.useful-categories.index') }}" class="sidebar-link">
                            <span class="nav-icon">
                                <i class="fa-light fa-filter-list"></i>
                            </span>
                                <span class="sidebar-txt">@lang('admin.categories')</span>
                            </a>
                        </li>
                    @endcan
                    @can('useful-view')
                        <li class="sidebar-dropdown-item">
                            <a href="{{ route('admin.useful.index') }}" class="sidebar-link">
                            <span class="nav-icon">
                                <i class="fa-light fa-filter-list"></i>
                            </span>
                                <span class="sidebar-txt">@lang('admin.useful')</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            <li class="sidebar-item">
                <a role="button" class="sidebar-link-group-title has-sub">@lang('admin.category_news')</a>
                <ul class="sidebar-link-group" @if(in_array(Route::currentRouteName(),['admin.category.index', 'admin.news.index'])) style="display: block;!important;" @else style="display: none;!important;" @endif>
                    @can('category-view')
                        <li class="sidebar-dropdown-item">
                            <a href="{{ route('admin.category.index') }}" class="sidebar-link">
                            <span class="nav-icon">
                                <i class="fa-light fa-filter-list"></i>
                            </span>
                                <span class="sidebar-txt">@lang('admin.categories')</span>
                            </a>
                        </li>
                    @endcan
                    @can('news-view')
                        <li class="sidebar-dropdown-item">
                            <a href="{{ route('admin.news.index') }}" class="sidebar-link">
                            <span class="nav-icon">
                                <i class="fa-light fa-filter-list"></i>
                            </span>
                                <span class="sidebar-txt">@lang('admin.news')</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            <li class="sidebar-item">
                <a role="button" class="sidebar-link-group-title has-sub">@lang('admin.career_contact_with')</a>
                <ul class="sidebar-link-group" @if(in_array(Route::currentRouteName(),['admin.career.index'])) style="display: block;!important;" @else style="display: none;!important;" @endif>
                    @can('career-view')
                        <li class="sidebar-dropdown-item">
                            <a href="{{ route('admin.career.index') }}" class="sidebar-link">
                        <span class="nav-icon">
                            <i class="fa-light fa-filter-list"></i>
                        </span>
                                <span class="sidebar-txt">@lang('admin.career')</span>
                            </a>
                        </li>
                        <li class="sidebar-dropdown-item">
                            <a href="{{ route('admin.career.contact') }}" class="sidebar-link">
                        <span class="nav-icon">
                            <i class="fa-light fa-filter-list"></i>
                        </span>
                                <span class="sidebar-txt">@lang('admin.career_contact')</span>
                            </a>
                        </li>
                        <li class="sidebar-dropdown-item">
                            <a href="{{ route('admin.career.volunteer') }}" class="sidebar-link">
                        <span class="nav-icon">
                            <i class="fa-light fa-filter-list"></i>
                        </span>
                                <span class="sidebar-txt">@lang('admin.volunteer')</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            <li class="sidebar-item">
                <a role="button" class="sidebar-link-group-title has-sub">@lang('admin.word_translations')</a>
                <ul class="sidebar-link-group" @if(in_array(Route::currentRouteName(),['admin.translations.index', 'admin.site-words.index', 'admin.admin-words.index'])) style="display: block;!important;" @else style="display: none;!important;" @endif>
                    {{--@can('translations-view')
                        <li class="sidebar-dropdown-item">
                            <a href="{{ route('admin.translations.index') }}" class="sidebar-link">
                                <span class="nav-icon">
                                    <i class="fa-light fa-filter-list"></i>
                                </span>
                                <span class="sidebar-txt">@lang('admin.translations')</span>
                            </a>
                        </li>
                    @endcan--}}
                    @can('translations-view')
                        <li class="sidebar-dropdown-item">
                            <a href="{{ route('admin.site-words.index') }}" class="sidebar-link">
                                <span class="nav-icon">
                                    <i class="fa-light fa-filter-list"></i>
                                </span>
                                <span class="sidebar-txt">@lang('admin.site_words')</span>
                            </a>
                        </li>
                    @endcan
                    @can('translations-view')
                        <li class="sidebar-dropdown-item">
                            <a href="{{ route('admin.admin-words.index') }}" class="sidebar-link">
                                <span class="nav-icon">
                                    <i class="fa-light fa-filter-list"></i>
                                </span>
                                <span class="sidebar-txt">@lang('admin.admin_words')</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            <li class="sidebar-item">
                <a role="button" class="sidebar-link-group-title has-sub">@lang('admin.contact')</a>
                <ul class="sidebar-link-group" @if(in_array(Route::currentRouteName(),['admin.complaint.index','admin.settings.index'])) style="display: block;!important;" @else style="display: none;!important;" @endif>
                    @can('complaints-view')
                        <li class="sidebar-dropdown-item">
                            <a href="{{ route('admin.complaint.index') }}" class="sidebar-link {{ Route::currentRouteName() === 'admin.complaint.index' ? 'active' : '' }}">
                        <span class="nav-icon">
                            <i class="fa-light fa-filter-list"></i>
                        </span>
                                <span class="sidebar-txt">@lang('admin.complaint')</span>
                            </a>
                        </li>
                    @endcan
                    @can('settings-view')
                        <li class="sidebar-dropdown-item">
                            <a href="{{ route('admin.settings.index') }}" class="sidebar-link  {{ Route::currentRouteName() === 'admin.settings.index' ? 'active' : '' }}">
                            <span class="nav-icon">
                                <i class="fa-light fa-filter-list"></i>
                            </span>
                                <span class="sidebar-txt">@lang('admin.settings')</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            <li class="sidebar-item">
                <a role="button" class="sidebar-link-group-title has-sub">@lang('admin.security')</a>
                <ul class="sidebar-link-group" @if(in_array(Route::currentRouteName(),['admin.cms-users.index', 'admin.cms-users.logs', 'admin.roles.index', 'admin.permissions.index', 'admin.settings.index'])) style="display: block;!important;" @else style="display: none;!important;" @endif>
                    @can('cms_users-view')
                    <li class="sidebar-dropdown-item">
                        <a href="{{ route('admin.cms-users.index') }}" class="sidebar-link">
                            <span class="nav-icon">
                                <i class="fa-light fa-filter-list"></i>
                            </span>
                            <span class="sidebar-txt">@lang('admin.cms_users')</span>
                        </a>
                    </li>
                    @endcan
                    @can('logs-view')
                    <li class="sidebar-dropdown-item">
                        <a href="{{ route('admin.cms-users.logs') }}" class="sidebar-link">
                            <span class="nav-icon">
                                <i class="fa-light fa-filter-list"></i>
                            </span>
                            <span class="sidebar-txt">@lang('admin.logs')</span>
                        </a>
                    </li>
                    @endcan
                    @can('roles-view')
                    <li class="sidebar-dropdown-item">
                        <a href="{{ route('admin.roles.index') }}" class="sidebar-link">
                            <span class="nav-icon">
                                <i class="fa-light fa-filter-list"></i>
                            </span>
                            <span class="sidebar-txt">@lang('admin.roles')</span>
                        </a>
                    </li>
                    @endcan
                    {{--@can('permissions-view')
                    <li class="sidebar-dropdown-item">
                        <a href="{{ route('admin.permissions.index') }}" class="sidebar-link">
                            <span class="nav-icon">
                                <i class="fa-light fa-filter-list"></i>
                            </span>
                            <span class="sidebar-txt">@lang('admin.permissions')</span>
                        </a>
                    </li>
                    @endcan--}}
                </ul>
            </li>
        </ul>
    </div>
</div>
