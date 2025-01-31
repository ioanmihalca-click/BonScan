<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'BonScan - Centralizator Motorină' }}</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/favicon/favicon-96x96.png') }}" sizes="96x96">
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/favicon/favicon.svg') }}">
    <link rel="shortcut icon" href="{{ asset('assets/favicon/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-touch-icon.png') }}">
    <meta name="apple-mobile-web-app-title" content="BonScan">
    <link rel="manifest" href="{{ asset('assets/favicon/site.webmanifest') }}">

       <!-- Open Graph / Social Media Meta Tags -->
   <meta property="og:title" content="BonScan - Centralizator Motorină">
   <meta property="og:description" content="Automatizează procesul de gestionare a bonurilor fiscale și generare a situațiilor centralizatoare pentru subvenția de motorină APIA.">
   <meta property="og:image" content="{{ asset('assets/OG-Bon.jpg') }}">
   <meta property="og:url" content="{{ url('/') }}">
   <meta property="og:type" content="website">
   <meta property="og:site_name" content="BonScan">

   <!-- Twitter Card Meta Tags -->
   <meta name="twitter:card" content="summary_large_image">
   <meta name="twitter:title" content="BonScan - Centralizator Motorină">
   <meta name="twitter:description" content="Automatizează procesul de gestionare a bonurilor fiscale și generare a situațiilor centralizatoare pentru subvenția de motorină APIA.">
   <meta name="twitter:image" content="{{ asset('assets/OG-Bon.jpg') }}">


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <livewire:layout.navigation />

        <!-- Page Content -->
        <main class="py-6">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Page Heading -->
                @if (isset($header))
                    <header class="mb-6">
                        {{ $header }}
                    </header>
                @endif

                <!-- Content -->
                {{ $slot }}
            </div>
        </main>
    </div>

    <x-footer />

    @livewireScripts

</body>

</html>
