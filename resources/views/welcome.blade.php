<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BonScan - Centralizator Motorină</title>

    <!-- Favicons -->
    <link rel="icon" type="image/png" href="{{ asset('assets/favicon/favicon-96x96.png') }}" sizes="96x96">
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/favicon/favicon.svg') }}">
    <link rel="shortcut icon" href="{{ asset('assets/favicon/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-touch-icon.png') }}">
    <meta name="apple-mobile-web-app-title" content="BonScan">
    <link rel="manifest" href="{{ asset('assets/favicon/site.webmanifest') }}">

    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:title" content="BonScan - Centralizator Motorină">
    <meta property="og:description"
        content="Automatizează procesul de gestionare a bonurilor fiscale și generare a situațiilor centralizatoare pentru subvenția de motorină APIA.">
    <meta property="og:image" content="{{ asset('assets/OG-Bon.jpg') }}">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="BonScan">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="BonScan - Centralizator Motorină">
    <meta name="twitter:description"
        content="Automatizează procesul de gestionare a bonurilor fiscale și generare a situațiilor centralizatoare pentru subvenția de motorină APIA.">
    <meta name="twitter:image" content="{{ asset('assets/OG-Bon.jpg') }}">

    <!-- Fonts and Styles -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="bg-gray-50 text-black/50">

        <nav class="bg-white shadow-sm">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Container principal cu padding ajustat pentru mobile -->
                <div class="relative flex items-center justify-between h-16">
                    <!-- Logo și text - ajustat pentru spacing consistent -->
                    <div class="flex items-center gap-2 shrink-0">
                        <img src="{{ asset('assets/logo.webp') }}" alt="BonScan Logo" class="w-8 h-8 md:w-10 md:h-10">
                        <span class="text-lg font-bold text-indigo-600 md:text-xl">BonScan</span>
                    </div>

                    <!-- Butoane autentificare/înregistrare - responsive cu spacing optimizat -->
                    <div class="flex items-center gap-2 sm:gap-4">
                        <a href="{{ route('login') }}"
                            class="px-2 py-1 text-sm text-gray-600 transition-colors duration-200 sm:px-3 sm:py-2 md:text-base hover:text-indigo-600">
                            Autentificare
                        </a>
                        <a href="{{ route('register') }}"
                            class="px-3 py-1.5 text-sm font-medium text-white transition-colors duration-200 bg-indigo-600 rounded-md sm:px-4 sm:py-2 md:text-base hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Înregistrare
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <div
            class="relative flex flex-col items-center justify-center min-h-screen selection:bg-indigo-500 selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <main class="mt-1">
                    <div class="flex flex-col items-center justify-center px-6 py-12 text-center">
                        <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl md:text-5xl lg:text-6xl">
                            <span class="block">Automatizează Procesul de</span>
                            <span class="block text-indigo-600">Subvenții pentru Motorină</span>
                        </h1>

                        <p class="max-w-xl mx-auto mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg md:mt-5 md:text-xl">
                            Simplifică procesul de gestionare a bonurilor fiscale și generare a situațiilor
                            centralizatoare pentru APIA.
                        </p>


                        <div class="flex flex-col justify-center gap-4 mt-8 sm:flex-row">
                            <a href="{{ route('register') }}"
                                class="inline-flex items-center justify-center w-full px-6 py-3 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm sm:w-auto hover:bg-indigo-700">
                                Începe Gratuit
                            </a>
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center justify-center w-full px-6 py-3 text-base font-medium text-indigo-600 bg-white border border-indigo-600 rounded-md shadow-sm sm:w-auto hover:bg-indigo-50">
                                Ai deja cont? Autentifică-te
                            </a>
                            <a href="#demo"
                                class="inline-flex items-center justify-center w-full px-6 py-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm sm:w-auto hover:bg-gray-50">
                                Vezi Demo
                            </a>
                        </div>

                        <div class="grid grid-cols-1 gap-4 mt-8 sm:grid-cols-3">
                            <div class="p-4 text-center bg-white rounded-lg shadow-sm">
                                <div class="text-3xl font-bold text-indigo-600">1000+</div>
                                <div class="text-gray-500">Bonuri Procesate</div>
                            </div>
                            <div class="p-4 text-center bg-white rounded-lg shadow-sm">
                                <div class="text-3xl font-bold text-indigo-600">50+</div>
                                <div class="text-gray-500">Ferme Mulțumite</div>
                            </div>
                            <div class="p-4 text-center bg-white rounded-lg shadow-sm">
                                <div class="text-3xl font-bold text-indigo-600">100%</div>
                                <div class="text-gray-500">Gratuit</div>
                            </div>
                        </div>

                        <div class="grid gap-8 mt-16 md:grid-cols-3 lg:gap-x-12">
                            <div class="p-6 bg-white rounded-lg shadow-lg">
                                <div class="inline-block p-3 text-indigo-600 bg-indigo-100 rounded-full">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                </div>
                                <h3 class="mt-4 text-lg font-semibold text-gray-900">Fotografiază Bonurile</h3>
                                <p class="mt-2 text-gray-600">Procesare automată a bonurilor fiscale cu extragere de
                                    date</p>
                            </div>

                            <div class="p-6 bg-white rounded-lg shadow-lg">
                                <div class="inline-block p-3 text-indigo-600 bg-indigo-100 rounded-full">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </div>
                                <h3 class="mt-4 text-lg font-semibold text-gray-900">Organizare pe Trimestre</h3>
                                <p class="mt-2 text-gray-600">Gestiune automată a situațiilor centralizatoare
                                    trimestriale</p>
                            </div>

                            <div class="p-6 bg-white rounded-lg shadow-lg">
                                <div class="inline-block p-3 text-indigo-600 bg-indigo-100 rounded-full">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <h3 class="mt-4 text-lg font-semibold text-gray-900">Export PDF</h3>
                                <p class="mt-2 text-gray-600">Generare automată a documentelor în formatul APIA</p>
                            </div>
                        </div>


                    </div>
                </main>

                <x-footer />

            </div>
        </div>
    </div>
</body>

</html>
