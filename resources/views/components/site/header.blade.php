<!-- cursor -->
<div class="mil-ball">
            <span class="mil-icon-1">
                <svg viewBox="0 0 128 128">
                    <path d="M106.1,41.9c-1.2-1.2-3.1-1.2-4.2,0c-1.2,1.2-1.2,3.1,0,4.2L116.8,61H11.2l14.9-14.9c1.2-1.2,1.2-3.1,0-4.2	c-1.2-1.2-3.1-1.2-4.2,0l-20,20c-1.2,1.2-1.2,3.1,0,4.2l20,20c0.6,0.6,1.4,0.9,2.1,0.9s1.5-0.3,2.1-0.9c1.2-1.2,1.2-3.1,0-4.2	L11.2,67h105.5l-14.9,14.9c-1.2,1.2-1.2,3.1,0,4.2c0.6,0.6,1.4,0.9,2.1,0.9s1.5-0.3,2.1-0.9l20-20c1.2-1.2,1.2-3.1,0-4.2L106.1,41.9	z" />
                </svg>
            </span>
    <div class="mil-more-text">@lang('site.more')</div>
    <div class="mil-choose-text">@lang('site.choose')</div>
</div>
<!-- cursor end -->

<!-- preloader -->
@if(Route::currentRouteName() === 'site.index')
<div class="mil-preloader">
    <div class="mil-preloader-animation">
        <div class="mil-pos-abs mil-animation-1">
            <p class="mil-h3 mil-muted mil-thin">Creative</p>
            <p class="mil-h3 mil-muted">.</p>
            <p class="mil-h3 mil-muted mil-thin">Agency</p>
        </div>
        <div class="mil-pos-abs mil-animation-2">
            <div class="mil-reveal-frame">
                <p class="mil-reveal-box"></p>
                <p class="mil-h3 mil-muted mil-thin">creativeagency.az</p>
            </div>
        </div>
    </div>
</div>
@endif
<!-- preloader end -->

<!-- scrollbar progress -->
<div class="mil-progress-track">
    <div class="mil-progress"></div>
</div>
<!-- scrollbar progress end -->

<!-- menu -->
<div class="mil-menu-frame">
    <!-- frame clone -->
    <div class="mil-frame-top">
        <a href="{{ route('site.index') }}" class="mil-logo">CO.</a>
        <div class="mil-menu-btn">
            <span></span>
        </div>
    </div>
    <!-- frame clone end -->
    <div class="container">
        <div class="mil-menu-content">
            <div class="row">
                <div class="col-xl-5">

                    <nav class="mil-main-menu" id="swupMenu">
                        <ul>
                            <li class="mil-has-children {{ Route::currentRouteName() === 'site.home' ? 'mil-active' : '' }}">
                                <a href="{{ route('site.index') }}">@lang('site.home')</a>
                            </li>
                            <li class="mil-has-children {{ Route::currentRouteName() === 'site.portfolio' ? 'mil-active' : '' }}">
                                <a href="{{ route('site.portfolio') }}">@lang('site.portfolio')</a>
                            </li>
                            <li class="mil-has-children">
                                <a href="#.">@lang('site.services')</a>
                                <ul>
                                    @if(!empty($services))
                                        @foreach($services as $service)
                                            <li class="{{ Route::currentRouteName() === 'site.service',$service['slug'][$currentLang] ? 'mil-active' : '' }}"><a href="{{ route('site.service',$service['slug'][$currentLang]) }}">{{ !empty($service['title'][$currentLang])? $service['title'][$currentLang]: null }}</a></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                            <li class="mil-has-children {{ Route::currentRouteName() === 'site.news' ? 'mil-active' : '' }}">
                                <a href="{{ route('site.news') }}">@lang('site.news')</a>
                            </li>
                            <li class="mil-has-children {{ Route::currentRouteName() === 'site.contact' ? 'mil-active' : '' }}">
                                <a href="{{ route('site.contact') }}">@lang('site.contact')</a>
                            </li>
                            <!-- Dil Seçimi -->


                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- menu -->

<!-- curtain -->
<div class="mil-curtain"></div>
<!-- curtain end -->

<!-- frame -->
<div class="mil-frame">
    <div class="mil-frame-top">
        <a href="{{ route('site.index') }}" class="mil-logo">CO.</a>
        <div class="mil-menu-btn">
            <span></span>
        </div>
    </div>
    <div class="mil-frame-bottom">
        <div class="mil-current-page"></div>
        <div class="mil-back-to-top">
            <a href="#top" class="mil-link mil-dark mil-arrow-place">
                <span></span>
            </a>
        </div>
    </div>
</div>
<!-- frame end -->
