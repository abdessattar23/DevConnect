<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/css/theme.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="relative min-h-screen bg-vintage-light">
            @if (Route::has('login'))
                <div class="p-6 text-right">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="nav-link font-medium">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="nav-link font-medium">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="nav-link ml-4 font-medium">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-center min-h-screen items-center">
                    <div class="text-center">
                        <h1 class="text-4xl font-bold text-vintage-dark mb-8">Welcome to LinkDev</h1>
                        <p class="text-xl text-vintage-brown mb-8">Connect, Share, and Grow with Fellow Developers</p>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-primary text-lg px-8 py-3">Get Started</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
