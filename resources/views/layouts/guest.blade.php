<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'DevConnect') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .glass-effect {
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                background: rgba(255, 255, 255, 0.95);
                border: 1px solid rgba(255, 255, 255, 0.2);
                box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            }
            .hover-scale { transition: transform 0.2s; }
            .hover-scale:hover { transform: scale(1.02); }
            .bg-pattern {
                background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            }
        </style>
    </head>
    <body class="font-sans text-gray-800 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative">
            <div class="absolute inset-0 bg-gradient-to-br from-[#0A66C2] to-[#0073B1] -z-10"></div>
            <div class="absolute inset-0 bg-pattern opacity-10 -z-10"></div>
            
            <div class="hover-scale">
                <a href="/">
                    <x-devconnect-logo class="w-48 h-12 fill-current text-white devconnect-logo" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-6 glass-effect rounded-xl overflow-hidden">
                {{ $slot }}
            </div>

            <div class="mt-8 text-center text-white text-sm opacity-80">
                <p>&copy; {{ date('Y') }} DevConnect. All rights reserved.</p>
            </div>
        </div>
    </body>
</html>
