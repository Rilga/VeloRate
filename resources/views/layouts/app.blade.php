<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Ikatan Akuntan Indonesia') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-900">
        <div class="min-h-screen bg-gray-100 flex flex-col lg:flex-row">
            
            {{-- 1. Navigation (Sidebars) --}}
            @auth
                @if(Auth::user()->role === 'admin')
                    @include('layouts.navigation.admin')
                @elseif(Auth::user()->role === 'manager')
                    @include('layouts.navigation.manager')
                @else
                    @include('layouts.navigation.user')
                @endif
            @endauth

            {{-- 2. Main Content Wrapper --}}
            {{-- lg:ml-64: Memberikan jarak agar konten tidak tertimpa sidebar fixed di desktop --}}
            {{-- pt-16: Memberikan jarak atas agar tidak tertutup mobile header di HP --}}
            <div class="flex-1 flex flex-col min-w-0 lg:ml-64 pt-16 lg:pt-0">
                
                @isset($header)
                    <header class="bg-white shadow-sm border-b border-gray-200">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main class="flex-1 py-6 md:py-10">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        {{ $slot }}
                    </div>
                </main>

                <footer class="py-6 text-center text-xs text-gray-400">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }} &bull; Performance System
                </footer>
            </div>
        </div>
    </body>
</html>