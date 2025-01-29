<div class="p-4 space-y-4 md:p-6 md:space-y-6">
    <!-- Sistem de notificări -->
    <div class="fixed right-0 z-50 w-full px-4 space-y-4 md:max-w-sm top-4 md:right-4 md:px-0">
        @if (session()->has('warning'))
            <div data-message="warning" 
                class="p-4 transition-all duration-300 transform border border-yellow-100 rounded-md shadow-lg bg-yellow-50">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="flex-1 ml-3">
                        <p class="text-sm font-medium text-yellow-800">{{ session('warning') }}</p>
                    </div>
                    <div class="ml-3">
                        <button wire:click="removeWarning" type="button" 
                            class="inline-flex rounded-md p-1.5 text-yellow-500 hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-yellow-600">
                            <span class="sr-only">Închide</span>
                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        @if (session()->has('success'))
            <div data-message="success" 
                class="p-4 transition-all duration-300 transform border border-green-100 rounded-md shadow-lg bg-green-50">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div class="flex-1 ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                    <div class="ml-3">
                        <button wire:click="removeSuccess" type="button" 
                            class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-600">
                            <span class="sr-only">Închide</span>
                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div data-message="error" 
                class="p-4 transition-all duration-300 transform border border-red-100 rounded-md shadow-lg bg-red-50">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <div class="flex-1 ml-3">
                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                    </div>
                    <div class="ml-3">
                        <button wire:click="removeError" type="button" 
                            class="inline-flex rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-600">
                            <span class="sr-only">Închide</span>
                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Header cu Stats -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-4 py-4 border-b border-gray-200 md:px-6 md:py-5">
            <div class="flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 md:text-xl">Situații Centralizatoare</h2>
                    <p class="mt-1 text-sm text-gray-500">Gestionează situațiile centralizatoare pentru subvenția de motorină</p>
                </div>
                <div class="flex flex-col items-stretch space-y-3 sm:flex-row sm:items-center sm:space-y-0 sm:space-x-4">
                    <select wire:model="perioada"
                        class="w-full py-2 pl-3 pr-10 text-base border-gray-300 rounded-md sm:w-64 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        @php
                            $currentYear = date('Y');
                            $years = range($currentYear - 1, $currentYear + 1);
                        @endphp
                        @foreach ($years as $year)
                            @foreach (range(1, 3) as $trimester)
                                <option value="{{ $year }}-T{{ $trimester }}">
                                    {{ $year }} - Trimestrul {{ $trimester }}
                                </option>
                            @endforeach
                        @endforeach
                    </select>

                    <button wire:click="genereazaSituatie"
                        wire:loading.attr="disabled"
                        @if($isProcessing) disabled @endif
                        class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm sm:w-auto hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span class="whitespace-nowrap">{{ $isProcessing ? 'Se generează...' : 'Generează Situație' }}</span>
                    </button>

                    <div wire:loading wire:target="genereazaSituatie" 
                        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-500 bg-opacity-20">
                        <div class="p-4 bg-white rounded-lg shadow-xl">
                            <svg class="w-8 h-8 text-indigo-600 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bon Management Component -->
    @if ($situatieCurenta && $showBonManagement)
        <div class="bg-white rounded-lg shadow">
            <livewire:bon-management :key="'bon-management-'.$situatieCurenta->id" :situatieId="$situatieCurenta->id" />
        </div>
    @endif

    <!-- Secțiunea de Situații -->
    @if ($situatii->isNotEmpty())
        <div class="overflow-hidden bg-white rounded-lg shadow" wire:poll.10s>
            <!-- Tabel pentru Desktop -->
            <div class="hidden md:block">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Perioada
                            </th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Status
                            </th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Nr. Bonuri
                            </th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Cantitate Totală
                            </th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">
                                Acțiuni
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($situatii as $situatie)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                    {{ $situatie->perioada }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $situatie->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $situatie->status === 'draft' ? 'În lucru' : 'Finalizat' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    {{ $situatie->bonuri->count() }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    @php $totals = $situatie->getTotals(); @endphp
                                    {{ number_format($totals['cantitate_utilizata'], 2) }} L
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <div class="flex justify-end space-x-3">
                                        @if ($situatie->status === 'draft')
                                            <button wire:click="finalizeazaSituatie({{ $situatie->id }})"
                                                class="text-green-600 hover:text-green-900">Finalizează</button>
                                        @endif
                                        <button wire:click="manageBonuri({{ $situatie->id }})"
                                            class="text-indigo-600 hover:text-indigo-900">
                                            {{ $situatieCurenta && $situatieCurenta->id === $situatie->id && $showBonManagement ? 'Închide' : 'Gestionează' }}
                                        </button>
                                        <button wire:click="exportPDF({{ $situatie->id }})"
                                            class="text-blue-600 hover:text-blue-900">Export</button>
                                        <livewire:situatie-metadata :situatieId="$situatie->id" 
                                            :wire:key="'metadata-'.$situatie->id">
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Card Layout pentru Mobile -->
            <div class="divide-y divide-gray-200 md:hidden">
                @foreach ($situatii as $situatie)
                    <div class="p-4 space-y-3">
                        <!-- Header cu perioada și status -->
                        <div class="flex items-center justify-between">
                            <div class="text-base font-semibold text-gray-900">
                                {{ $situatie->perioada }}
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $situatie->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                {{ $situatie->status === 'draft' ? 'În lucru' : 'Finalizat' }}
                            </span>
                        </div>

                        <!-- Informații detaliate -->
                        <div class="grid grid-cols-2 gap-4 py-2">
                            <div>
                                <div class="text-sm text-gray-500">Nr. Bonuri</div>
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $situatie->bonuri->count() }}
                                </div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500">Cantitate Totală</div>
                                <div class="text-sm font-medium text-gray-900">
                                    @php $totals = $situatie->getTotals(); @endphp
                                    {{ number_format($totals['cantitate_utilizata'], 2) }} L
                                </div>
                            </div>
                        </div>

                        <!-- Butoane de acțiune -->
                        <div class="flex flex-wrap items-center justify-end gap-2 pt-2">
                            @if ($situatie->status === 'draft')
                                <button wire:click="finalizeazaSituatie({{ $situatie->id }})"
                                    class="inline-flex items-center px-3 py-1.5 text-sm text-white bg-green-600 rounded-md hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Finalizează
                                </button>
                            @endif

                            <button wire:click="manageBonuri({{ $situatie->id }})"
                                class="inline-flex items-center px-3 py-1.5 text-sm text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                {{ $situatieCurenta && $situatieCurenta->id === $situatie->id && $showBonManagement ? 'Închide' : 'Gestionează' }}
                            </button>

                            <button wire:click="exportPDF({{ $situatie->id }})"
                                class="inline-flex items-center px-3 py-1.5 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Export
                            </button>

                            <livewire:situatie-metadata :situatieId="$situatie->id" :wire:key="'metadata-'.$situatie->id">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="p-4 text-center bg-white rounded-lg shadow md:p-6">
            <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Nu există situații</h3>
            <p class="mt-1 text-sm text-gray-500">Generează o situație nouă pentru a începe.</p>
        </div>
    @endif

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('refresh-component', () => {
                Livewire.dispatch('$refresh');
            });

            const animateAndRemove = (element, type) => {
                element.style.opacity = '0';
                element.style.transform = 'translateX(100%)';
                
                setTimeout(() => {
                    Livewire.dispatch(`remove-${type}`);
                }, 300);
            };

            const setMessageTimer = (type) => {
                const messageElement = document.querySelector(`[data-message="${type}"]`);
                if (messageElement) {
                    setTimeout(() => {
                        animateAndRemove(messageElement, type);
                    }, 5000);
                }
            };

            ['warning', 'success', 'error'].forEach(type => {
                setMessageTimer(type);
            });

            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    mutation.addedNodes.forEach((node) => {
                        if (node.nodeType === 1 && node.hasAttribute('data-message')) {
                            const type = node.getAttribute('data-message');
                            setMessageTimer(type);
                        }
                    });
                });
            });

            const notificationsContainer = document.querySelector('.fixed.z-50');
            if (notificationsContainer) {
                observer.observe(notificationsContainer, { 
                    childList: true,
                    subtree: true 
                });
            }
        });
    </script>
</div>