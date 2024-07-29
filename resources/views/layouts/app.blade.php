<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .full-height {
            height: 100vh;
        }

        .centered-content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        .header {
            width: 100%;
            background-color: #f8f9fa;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
        }
        .header .navbar-brand {
            margin: 0;
        }

        .layout-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #f8f9fa;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
        }
    </style>

    <!-- Scripts -->
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
    <div id="app">
        <!-- Header -->
        <div class="header">
            <div class="container">
                <nav class="navbar navbar-expand-md navbar-light">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('img/logo.png') }}" alt="{{ config('app.name', 'On the Spot Courier') }}" style="height: 40px;">
                        {{ config('app.name', 'On the Spot Courier') }}
                    </a>
                </nav>
            </div>
        </div>

        <!-- Content -->
        @guest
            <div class="full-height centered-content">
                <div class="login-card">
                    @yield('guest-content')
                </div>
            </div>
        @else
            <div class="layout-wrapper">
                @auth
                <!-- Sidebar -->
                <div class="sidebar">
                    <h5>Menu</h5>
                    <ul class="nav flex-column">
                        @include('layouts.navigation')
                    </ul>
                </div>
                @endauth

                <!-- Main Content -->
                <div class="main-content">
                    @yield('content')
                </div>
            </div>
        @endguest
    </div>
</body>
</html>
