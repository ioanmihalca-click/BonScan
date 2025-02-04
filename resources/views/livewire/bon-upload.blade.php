<div class="space-y-6">
    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium text-gray-900">
                Încărcare Bonuri Fiscale
            </h3>

            <div class="mt-2 text-sm text-gray-500">
                <p>Încarcă unul sau mai multe bonuri fiscale pentru procesare automată. Sunt acceptate imagini în format
                    JPG, PNG până la 5MB per bon.</p>

                <div class="p-4 mt-2 rounded-md bg-blue-50">
                    <p class="font-medium text-blue-800">Recomandări importante:</p>
                    <ul class="mt-2 ml-4 text-blue-700 list-disc">
                        <li>Faceți poze clare bonurilor, asigurându-vă că textul este vizibil</li>
                        <li>Evitați umbrele sau reflexiile pe bon</li>
                        <li>Încărcați maxim 10 bonuri odată pentru procesare optimă</li>
                        <li>Timpul de procesare variază între 10-30 secunde per bon</li>
                    </ul>
                </div>
            </div>


            <form wire:submit="save">
                @if ($message)
                    <div
                        class="p-4 mb-4 rounded-md {{ str_contains($message, 'Eroare') ? 'bg-red-50 text-red-700' : 'bg-green-50 text-green-700' }}">
                        <p class="text-sm">{{ $message }}</p>
                    </div>
                @endif

                <div class="mt-4">
                    <label
                        class="flex flex-col items-center px-4 py-6 bg-white border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:bg-gray-50">
                        <div class="flex flex-col items-center">
                            <!-- Icon normal -->
                            <div wire:loading.remove wire:target="bonuri">
                                <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>

                            <!-- Loading spinner -->
                            <div wire:loading wire:target="bonuri">
                                <svg class="w-8 h-8 text-indigo-500 animate-spin" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </div>

                            <!-- Text -->
                            <p class="mt-2 text-sm text-gray-600">
                                <span wire:loading.remove wire:target="bonuri" class="font-medium text-indigo-600">
                                    Apasă pentru a selecta bonuri
                                </span>
                                <span wire:loading wire:target="bonuri" class="font-medium text-indigo-600">
                                    Se încarcă...
                                </span>
                                @if (count($bonuri) > 0)
                                    <span class="text-gray-500"> - {{ count($bonuri) }} bonuri selectate</span>
                                @endif
                            </p>
                            <p class="mt-1 text-xs text-gray-500">JPG, PNG până la 5MB per bon</p>
                        </div>
                        <input type="file" wire:model="bonuri" accept="image/*" class="hidden" multiple>
                    </label>

                    @error('bonuri.*')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Preview bonuri selectate -->
                @if ($isUploading)
                    <div class="flex items-center justify-center w-full p-4 mt-4">
                        <div class="text-center">
                            <svg class="w-8 h-8 mx-auto text-indigo-500 animate-spin" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">Se încarcă bonurile...</p>
                        </div>
                    </div>
                @elseif (count($bonuri) > 0)
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        @foreach ($bonuri as $index => $bon)
                            <div class="relative">
                                <img src="{{ $bon->temporaryUrl() }}" class="object-cover w-full h-32 rounded-lg">
                                <div class="absolute top-0 right-0 m-1">
                                    <button type="button" wire:click="$set('bonuri.{{ $index }}', null)"
                                        class="p-1 text-red-600 bg-red-100 rounded-full hover:bg-red-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="mt-4">
                    <button type="submit"
                        class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove>Procesează Bonurile</span>
                        <span wire:loading class="flex items-center">
                            <svg class="w-5 h-5 mr-3 -ml-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            {{-- Se procesează... --}}
                        </span>
                    </button>
                </div>

                <!-- Progress Bar -->
                @if ($totalJobs > 0 && !$processingComplete)
                    <div class="p-4 mt-4 rounded-lg bg-gray-50">
                        <div class="relative pt-1">
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <span class="inline-block text-xs font-semibold text-indigo-600">
                                        Progres Procesare
                                    </span>
                                </div>
                                <div class="text-right">
                                    <span class="inline-block text-xs font-semibold text-indigo-600">
                                        {{ $completedJobs }}/{{ $totalJobs }} bonuri procesate
                                    </span>
                                </div>
                            </div>
                            <div class="flex h-2 mb-4 overflow-hidden text-xs bg-indigo-200 rounded">
                                <div style="width:{{ ($completedJobs / $totalJobs) * 100 }}%"
                                    class="flex flex-col justify-center text-center text-white transition-all duration-500 bg-indigo-500 shadow-none whitespace-nowrap">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

        </div>

        <div class="space-y-6">

            @if (!empty($rezultateOcr))
                <div class="p-4 mt-6 rounded-lg bg-gray-50">
                    <h4 class="mb-3 text-sm font-medium text-gray-900">Status Procesare Bonuri</h4>
                    <div class="space-y-2">
                        @foreach ($rezultateOcr as $rezultat)
                            <div class="flex items-center justify-between py-2 border-b border-gray-200 last:border-0">
                                <span class="text-sm text-gray-600">Bon
                                    #{{ $rezultat->numar_bon ?? 'În procesare' }}</span>
                                <span
                                    class="px-2 py-1 text-sm rounded-full 
                                        {{ $rezultat->verified_at
                                            ? 'bg-green-100 text-green-800'
                                            : ($rezultat->error
                                                ? 'bg-red-100 text-red-800'
                                                : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ $rezultat->verified_at ? 'Procesat' : ($rezultat->error ? 'Eroare' : 'În procesare') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            </form>
        </div>
    </div>

    @if ($showEdit && count($rezultateOcr) > 0)
        @foreach ($rezultateOcr as $rezultat)
            <div class="mt-8">
                <livewire:edit-rezultat-ocr :rezultat="$rezultat" :wire:key="'edit-'.$rezultat->id" />
            </div>
        @endforeach
    @endif

    <livewire:lista-bonuri />

    <script>
        document.addEventListener('livewire:initialized', () => {
            let checkInterval;
            let isChecking = false;

            const startChecking = () => {
                // Prevent multiple intervals
                if (isChecking) return;
                isChecking = true;

                console.log('Starting processing check...'); // Debug log

                // Clear any existing interval
                if (checkInterval) {
                    clearInterval(checkInterval);
                }

                // Start a new interval
                checkInterval = setInterval(() => {
                    console.log('Checking processing status...'); // Debug log
                    Livewire.dispatch('checkProcessingStatus');
                }, 2000); // Check every 2 seconds

                // Stop after 5 minutes or when processing is complete
                setTimeout(() => {
                    if (checkInterval) {
                        clearInterval(checkInterval);
                        isChecking = false;
                        console.log('Checking stopped after timeout'); // Debug log
                    }
                }, 300000);
            };

            // Start checking when component signals
            Livewire.on('startProcessingCheck', () => {
                console.log('Received startProcessingCheck event'); // Debug log
                startChecking();
            });

            // Check on component load if needed
            window.addEventListener('load', () => {
                if (document.querySelector('[wire\\:id]')) {
                    startChecking();
                }
            });

            // Listen for processing complete
            Livewire.on('processingComplete', () => {
                if (checkInterval) {
                    clearInterval(checkInterval);
                    isChecking = false;
                    console.log('Processing complete, checks stopped'); // Debug log
                }
            });
        });
    </script>

</div>
