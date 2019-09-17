<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="@yield('description', 'Review Công ty - Review lương bổng, đãi ngộ, HR, sếp và công việc,... gì cũng có')" />
    <title>@yield('title', 'Review Công ty - Review lương bổng, đãi ngộ, HR, sếp và công việc,... gì cũng có')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRF Token -->
    <link href="/css/app.css" rel="stylesheet"> <!-- Styles -->
    <link rel="apple-touch-icon" sizes="57x57" href="/images/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/images/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/images/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/images/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/images/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/images/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/images/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/images/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/images/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/images/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon-16x16.png">
    <link rel="manifest" href="/images/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/images/ms-icon-144x144.png">
    <meta name="theme-color" content="#302b63">
    <script src="//google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer></script>
    <script type="text/javascript">
      /* <![CDATA[ */
      var SITE_KEY = '{{ config('site.site_key_google') }}';
      /* ]]> */
    </script>
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
    <script src="/js/app.js" defer></script> <!-- Scripts -->
    @stack('scripts')
</body>
</html>
