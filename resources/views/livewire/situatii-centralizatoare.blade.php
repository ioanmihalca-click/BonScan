<div class="p-6 space-y-6">
    <!-- Header with Stats -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-5 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Situații Centralizatoare</h2>
                    <p class="mt-1 text-sm text-gray-500">Gestionează situațiile centralizatoare pentru subvenția de
                        motorină</p>
                </div>
                <div class="flex items-center space-x-4">
                    <select wire:model="perioada"
                        class="block w-64 py-2 pl-3 pr-10 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        @php
                            $currentYear = date('Y');
                            $years = range($currentYear - 1, $currentYear + 1);
                        @endphp
                        @foreach ($years as $year)
                            @foreach (range(1, 3) as $trimester)
                                <option value="{{ $year }}-T{{ $trimester }}">{{ $year }} - Trimestrul
                                    {{ $trimester }}</option>
                            @endforeach
                        @endforeach
                    </select>

                    <button wire:click="genereazaSituatie"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Generează Situație
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bon Management Component -->
    @if ($situatieCurenta)
        <div class="bg-white rounded-lg shadow">
            <livewire:bon-management :situatieId="$situatieCurenta->id" />
        </div>
    @endif

    <!-- Table Section -->
    @if ($situatii->isNotEmpty())
        <div class="bg-white rounded-lg shadow">
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Perioada</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Status</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Nr. Bonuri</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Cantitate Totală</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">
                                Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($situatii as $situatie)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                    {{ $situatie->perioada }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $situatie->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $situatie->status === 'draft' ? 'În lucru' : 'Finalizat' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                    {{ $situatie->bonuri->count() }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                    @php $totals = $situatie->getTotals(); @endphp
                                    {{ number_format($totals['cantitate_utilizata'], 2) }} L
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <div class="flex justify-end space-x-3">
                                        @if ($situatie->status === 'draft')
                                            <button wire:click="finalizeazaSituatie({{ $situatie->id }})"
                                                class="inline-flex items-center text-sm text-green-600 hover:text-green-900">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Finalizează
                                            </button>
                                        @endif

                                        <button wire:click="manageBonuri({{ $situatie->id }})"
                                            class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                            Gestionează
                                        </button>

                                        <button wire:click="exportPDF({{ $situatie->id }})"
                                            class="inline-flex items-center text-sm text-blue-600 hover:text-blue-900">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            Export
                                        </button>
                                        <livewire:situatie-metadata :situatieId="$situatie->id"
                                            :wire:key="'metadata-'.$situatie->id">
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="p-6 text-center bg-white rounded-lg shadow">
            <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Nu există situații</h3>
            <p class="mt-1 text-sm text-gray-500">Generează o situație nouă pentru a începe.</p>
        </div>
    @endif
</div>
