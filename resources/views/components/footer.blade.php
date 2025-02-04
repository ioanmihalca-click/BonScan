<footer class="py-12 bg-gradient-to-b from-white to-gray-50">
    <div class="max-w-4xl px-4 mx-auto">
        {{-- Disclaimer Section --}}
        <div class="mb-10">
            <div class="p-4 border rounded-lg bg-amber-50 border-amber-200">
                <div class="flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                        <line x1="12" y1="9" x2="12" y2="13"/>
                        <line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                    <p class="font-medium text-amber-800">
                        Atât oamenii cât și AI-ul pot face erori. Vă rugăm verificați datele generate și editați-le dacă este necesar!
                    </p>
                </div>
            </div>
        </div>

        {{-- Donation Section --}}
        <div class="mb-10 space-y-6">
            <p class="max-w-2xl mx-auto text-center text-gray-600">
                Pentru a menține și dezvolta această platformă avem nevoie de sprijinul dumneavoastră. 
                Costurile de întreținere a serverelor și ale modelelor AI sunt semnificative.
            </p>
            
            <div class="p-6 space-y-4 bg-indigo-50 rounded-xl">
                <p class="text-center text-gray-700">
                    Dacă doriți să susțineți dezvoltarea acestui proiect și a altor aplicații similare, 
                    puteți face o donație pe Revolut
                </p>
                
                <div class="flex justify-center">
                    <a href="https://revolut.me/clickstudios" 
                       class="inline-flex items-center gap-2 px-6 py-3 font-medium text-white transition-colors duration-200 bg-indigo-600 rounded-lg hover:bg-indigo-700"
                       target="_blank"
                       rel="noopener noreferrer">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 8V7M12 8C10.343 8 9 8.895 9 10C9 11.105 10.343 12 12 12C13.657 12 15 12.895 15 14C15 15.105 13.657 16 12 16M12 8C13.11 8 14.08 8.402 14.599 9M12 16V17M12 16C10.89 16 9.92 15.598 9.401 15" 
                                  stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        Donează prin Revolut
                    </a>
                </div>
            </div>
        </div>

        {{-- Brand Section --}}
        <div class="flex flex-col items-center pt-6 space-y-4 border-t border-gray-200">
            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/logo.webp') }}" alt="BonScan Logo" class="w-12 h-12">
                <span class="text-2xl font-bold text-transparent bg-gradient-to-r from-indigo-600 to-indigo-500 bg-clip-text">
                    BonScan
                </span>
            </div>

            <div class="text-sm text-gray-500">
                <span>Powered by </span>
                <a href="https://clickstudios-digital.com" 
                   class="font-medium text-indigo-600 transition-colors hover:text-indigo-500"
                   target="_blank" 
                   rel="noopener noreferrer">
                    ClickStudios Digital
                </a>
            </div>

            <div class="text-sm text-gray-500">
                &copy; {{ date('Y') }} BonScan. Toate drepturile rezervate.
            </div>
        </div>
    </div>
</footer>