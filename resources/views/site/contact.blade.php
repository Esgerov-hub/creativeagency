@extends('site.layouts.app')
@section('site.title')
    @lang('site.contact')
@endsection
@section('site.css')
@endsection
@section('site.content')
    <!-- banner -->
    <div class="mil-inner-banner mil-p-0-120">
        <div class="mil-banner-content mil-center mil-up">
            <div class="container">
                <ul class="mil-breadcrumbs mil-center mil-mb-60">
                    <li><a href="{{ route('site.index') }}">@lang('site.home')</a></li>
                    <li><a href="">@lang('site.contact')</a></li>
                </ul>
                <h1 class="mil-mb-60">@lang('site.send_messages')</h1>
                <div class="mil-info mil-up mil-mb-90" style="translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">
                    <div>&nbsp;<span class="mil-dark">{{ !empty($setting['address'][$currentLang])? $setting['address'][$currentLang]: NULL }}</span></div>
                    <div>&nbsp;<span class="mil-dark">{{ !empty($setting['phone'])? $setting['phone']: NULL }}</span></div>
                    <div>&nbsp;<span class="mil-dark">{{ !empty($setting['email'])? $setting['email']: NULL }}</span></div>
                </div>
                <a href="#contact" class="mil-link mil-dark mil-arrow-place mil-down-arrow">
                    <span></span>
                </a>
            </div>
        </div>
    </div>
    <!-- banner end -->

    <!-- contact form -->
    <section id="contact">
        <div class="container mil-p-120-90">
            <form id="contactForm" class="row align-items-center">
                <div class="col-lg-6 mil-up">
                    <input type="text" id="name" name="name" placeholder="@lang('site.name')" required>
                </div>
                <div class="col-lg-6 mil-up">
                    <input type="text" id="surname" name="surname" placeholder="@lang('site.surname')" required>
                </div>
                <div class="col-lg-6 mil-up">
                    <input type="email" id="email" name="email" placeholder="info@creativeagency.az" required>
                </div>
                <div class="col-lg-6 mil-up">
                    <input type="phone" id="phone" name="phone" placeholder="+994** *** ** **" required>
                </div>
                <div class="col-lg-12 mil-up">
                    <textarea id="note" name="note" placeholder="@lang('site.more_subject')" required></textarea>
                </div>
                <div class="col-lg-4">
                    <div class="mil-adaptive-right mil-up mil-mb-30">
                        <button type="submit" class="mil-button mil-arrow-place">
                            <span>@lang('site.contact')</span>
                        </button>
                    </div>
                </div>
            </form>
            <div id="formResponse" style="margin-top: 20px;"></div>
        </div>
    </section>
    <!-- contact form end -->
@endsection
@section('site.js')
    <script>
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Відміняємо стандартну відправку форми

            const formData = new FormData(this);

            fetch('{{ route('site.sendContact') }}', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    const responseDiv = document.getElementById('formResponse');
                    if (data.success) {
                        responseDiv.innerHTML = '<p style="color: green;">Message sent successfully!</p>';
                        document.getElementById('contactForm').reset(); // Очистити форму
                    } else {
                        responseDiv.innerHTML = `<p style="color: red;">Error: ${data.error}</p>`;
                    }
                })
                .catch(error => {
                    document.getElementById('formResponse').innerHTML = `<p style="color: red;">An unexpected error occurred: ${error.message}</p>`;
                });
        });

    </script>
@endsection
