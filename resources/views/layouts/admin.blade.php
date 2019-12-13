<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', __('Dashboard'))</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="//fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="/css/admin.css" rel="stylesheet">

    <!-- Scripts -->
    <script src="/js/admin.js" defer></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Training laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @if(Auth::guard('admin')->check())
                            @can('company-list')
                                <li class="nav-item dropdown">
                                    <a class="nav-link" href="{{ route('manage.companies.index') }}">{{ __('Manage Companies') }}</a>
                                </li>
                            @endcan
                            @can('comment-list')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('manage.comments.index') }}">{{ __('Manage Comments') }}</a>
                                </li>
                            @endcan
                            @can('user-list')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('manage.users.index') }}">{{ __('Manage Users') }}</a>
                                </li>
                            @endcan
                            @can('role-list')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('manage.roles.index') }}">{{ __('Manage Role') }}</a>
                                </li>
                            @endcan
                            @can('admin-list')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('manage.admins.index') }}">{{ __('Manage Admins') }}</a>
                                </li>
                            @endcan
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        @if(Auth::guard('admin')->check())
                            <li class="nav-item dropdown">
                                <a id="adminDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::guard('admin')->user()->name }} <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="adminDropdown">
                                    <a href="{{route('manage.home')}}" class="dropdown-item">Dashboard</a>
                                    <a class="dropdown-item" href="#" onclick="event.preventDefault();document.querySelector('#admin-logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="admin-logout-form" action="{{ route('manage.logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
