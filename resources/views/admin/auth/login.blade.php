<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creative Agency -@lang('admin.login')</title>
    <link rel="shortcut icon" href="{{ asset('admin/avatar/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <link rel="stylesheet" id="primaryColor" href="{{ asset('admin/assets/css/blue-color.css') }}">
</head>
<body class="light-theme">
<!-- preloader start -->
<div class="preloader d-none">
    <div class="loader">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
<!-- preloader end -->

<!-- main content start -->
<div class="main-content login-panel login-panel-3">
    <div class="container">
        <div class="d-flex justify-content-end">
            <div class="login-body">
                <div class="top d-flex justify-content-between align-items-center">
                    <div class="logo">
                        <img src="{{ asset('admin/avatar/logo.png') }}" alt="Logo">
                    </div>
                    <a href="{{ route('admin.index') }}"><i class="fa-duotone fa-house-chimney"></i></a>
                </div>
                <div class="bottom">
                    <h3 class="panel-title">@lang('admin.login')</h3>
                    @include('components.admin.error')
                    <form action="{{ route('admin.loginAccept') }}" method="POST">
                        @csrf
                        <div class="input-group mb-25">
                            <span class="input-group-text"><i class="fa-regular fa-user"></i></span>
                            <input type="text" class="form-control" name="email" placeholder="info@creativeagency.az" value="{{ old('email') }}">
                        </div>
                        <div class="input-group mb-20">
                            <span class="input-group-text"><i class="fa-regular fa-lock"></i></span>
                            <input type="password" name="password" class="form-control rounded-end" placeholder="******">
                            <a role="button" class="password-show"><i class="fa-duotone fa-eye"></i></a>

                        </div>
                        <button class="btn btn-primary w-100 login-btn">@lang('admin.login')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- footer start -->
    <div class="footer">
        <p>© <script>document.write(new Date().getFullYear())</script> Bütün hüquqlar qorunur <a href="https://creativeagency.az" target="_blank" title="Creative Agency"><span class="text-primary">Creative Agency</span></a></p>
    </div>
    <!-- footer end -->
</div>
<!-- main content end -->

<script src="{{ asset('admin/assets/vendor/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/main.js') }}"></script>
<!-- for demo purpose -->
<script>
    var rtlReady = $('html').attr('dir', 'ltr');
    if (rtlReady !== undefined) {
        localStorage.setItem('layoutDirection', 'ltr');
    }
</script>
<!-- for demo purpose -->
</body>
</html>