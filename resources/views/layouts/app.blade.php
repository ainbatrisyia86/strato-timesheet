<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Strato Timesheet System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">

    <!-- Main container with always white background -->
    <div class="min-h-screen bg-white">

        {{-- Navigation --}}
        @include('layouts.navigation')

        {{-- Page Heading (optional header section) --}}
        @isset($header)
            <header class="bg-white shadow flex justify-center">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-center">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Page Content --}}
        <main class="pt-2 sm:pt-4 lg:pt-6">
             @isset($slot)
                {{ $slot }}
            @endisset

            @yield('content')
        </main> 
    </div>

</body>
</html>
