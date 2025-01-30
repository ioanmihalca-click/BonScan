<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>BonScan - Centralizator Motorină</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="bg-gray-50 text-black/50">
            <div class="relative flex flex-col items-center justify-center min-h-screen selection:bg-indigo-500 selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <header class="grid items-center grid-cols-2 gap-2 py-10 lg:grid-cols-3">
                        <div class="flex lg:justify-center lg:col-start-2">
                            <span class="text-3xl font-bold text-indigo-600">BonScan</span>
                        </div>
                        @if (Route::has('login'))
                            <div class="flex justify-end">
                                @auth
                                    <a href="{{ route('dashboard') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500">Autentificare</a>
                                @endauth
                            </div>
                        @endif
                    </header>

                    <main class="mt-6">
                        <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                            <!-- Left Column - Product Info -->
                            <div class="flex flex-col items-start gap-6 p-6 overflow-hidden bg-white rounded-lg shadow-lg lg:p-10">
                                <div class="pt-3 sm:pt-5">
                                    <h1 class="text-3xl font-bold text-gray-900">Automatizează Procesul de Subvenții pentru Motorină</h1>

                                    <p class="mt-4 text-lg text-gray-600">
                                        Simplifică procesul de gestionare a bonurilor fiscale și generare a situațiilor centralizatoare pentru APIA.
                                    </p>

                                    <div class="mt-8 space-y-6">
                                        <div class="flex items-start gap-3">
                                            <div class="flex-shrink-0">
                                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="font-semibold text-gray-900">Scanare și OCR</h3>
                                                <p class="text-gray-600">Procesare automată a bonurilor fiscale cu extragere de date</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start gap-3">
                                            <div class="flex-shrink-0">
                                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="font-semibold text-gray-900">Organizare pe Trimestre</h3>
                                                <p class="text-gray-600">Gestiune automată a situațiilor centralizatoare trimestriale</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start gap-3">
                                            <div class="flex-shrink-0">
                                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="font-semibold text-gray-900">Export PDF</h3>
                                                <p class="text-gray-600">Generare automată a documentelor în formatul APIA</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Login Form -->
                            {{-- <div class="flex items-center justify-center">
                                <div class="w-full max-w-md">
                                    <div class="px-4 py-8 bg-white rounded-lg shadow-2xl sm:px-10">
                                        <div class="mb-6 sm:mx-auto sm:w-full sm:max-w-md">
                                            <h2 class="text-2xl font-bold text-center text-gray-900">
                                                Autentificare
                                            </h2>
                                        </div>
                                        <livewire:login-form />
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </main>

                    <footer class="py-16 text-sm text-center text-gray-600">
                        &copy; {{ date('Y') }} BonScan. Toate drepturile rezervate.
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>