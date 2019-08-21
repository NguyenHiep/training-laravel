<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Review Công ty - Review lương bổng, đãi ngộ, HR, sếp và công việc,... gì cũng có" />
    <title>Review Công ty - Review lương bổng, đãi ngộ, HR, sếp và công việc,... gì cũng có</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRF Token -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> <!-- Styles -->
    <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer></script>
</head>
<body>
    <div id="app">
        <!-- Begin .main-nav -->
        <nav class="main-nav navbar p-0">
            <div class="container">
                <div class="logo">
                    <a href="{{ url('/') }}"><img class="logo-img" src="{{ asset('images/logo.png') }}" alt="logo" /></a>
                    <h1 class="logo-title"><a href="{{ url('/') }}">Review Công ty</a></h1>
                </div>
            </div>
        </nav>
        <!-- End .main-nav -->
        <main class="main-container">
            @yield('content')
        </main>
        <footer class="main-footer">
            <div class="container">
                <a href="{{ route('fqa') }}" target="_blank">Giải đáp thắc mắc - Yêu cầu xóa review</a> | <a href="{{ route('tnc') }}" target="_blank">Điều khoản sử dụng</a>
            </div>
        </footer>
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script> <!-- Scripts -->
    @stack('scripts')
</body>
</html>
