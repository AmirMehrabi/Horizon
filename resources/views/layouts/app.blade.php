@php
    $direction = config('ui.direction', 'ltr');
    $language = config('ui.language', 'en');
    $isRtl = $direction === 'rtl';
    $isFarsi = $language === 'fa';
@endphp

<!DOCTYPE html>
<html lang="{{ $language === 'fa' ? 'fa' : 'en' }}" dir="{{ $direction }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', config('app.name', 'آویاتو'))</title>

    <!-- Fonts -->
    @if(!$isFarsi)
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @endif

    <!-- Pelak Font Face Declarations (Local) -->
    @if($isFarsi)
    <style>
        @font-face {
            font-family: 'Pelak';
            src: url('{{ asset('assets/fonts/pelak.woff2') }}') format('woff2'),
                 url('{{ asset('assets/fonts/pelak.woff') }}') format('woff');
            font-weight: 400;
            font-style: normal;
            font-display: swap;
        }
        
        @font-face {
            font-family: 'Pelak';
            src: url('{{ asset('assets/fonts/pelak.woff2') }}') format('woff2'),
                 url('{{ asset('assets/fonts/pelak.woff') }}') format('woff');
            font-weight: 500;
            font-style: normal;
            font-display: swap;
        }
        
        @font-face {
            font-family: 'Pelak';
            src: url('{{ asset('assets/fonts/pelak.woff2') }}') format('woff2'),
                 url('{{ asset('assets/fonts/pelak.woff') }}') format('woff');
            font-weight: 600;
            font-style: normal;
            font-display: swap;
        }
        
        @font-face {
            font-family: 'Pelak';
            src: url('{{ asset('assets/fonts/pelak.woff2') }}') format('woff2'),
                 url('{{ asset('assets/fonts/pelak.woff') }}') format('woff');
            font-weight: 700;
            font-style: normal;
            font-display: swap;
        }
        
        body, * {
            font-family: 'Pelak', 'Tahoma', 'Arial', sans-serif !important;
        }
    </style>
    @endif

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /* Tailwind CSS will be injected here */
        </style>
    @endif

    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased" style="direction: {{ $direction }};">
    @yield('content')

    @stack('scripts')
</body>
</html>
