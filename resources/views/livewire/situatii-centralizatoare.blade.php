<div class="p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold">Situații Centralizatoare</h2>

        <div class="flex space-x-4">
            <select wire:model="perioada" class="border-gray-300 rounded-md">
                @php
                    $currentYear = date('Y');
                    $years = range($currentYear - 1, $currentYear + 1);
                @endphp
                @foreach ($years as $year)
                    <option value="{{ $year }}-T1">{{ $year }} - Trimestrul I</option>
                    <option value="{{ $year }}-T2">{{ $year }} - Trimestrul II</option>
                    <option value="{{ $year }}-T3">{{ $year }} - Trimestrul III</option>
                @endforeach
            </select>

            <button wire:click="genereazaSituatie" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                Generează Situație
            </button>
        </div>
    </div>

    <!-- Bon Management Component -->
    @if ($situatieCurenta)
        <div class="mb-6">
            <livewire:bon-management :situatieId="$situatieCurenta->id" />
        </div>
    @endif

    @if ($situatii->isNotEmpty())
        <div class="overflow-hidden bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Perioada</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Status</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Nr.
                            Bonuri</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Cantitate Totală</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Acțiuni</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($situatii as $situatie)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $situatie->perioada }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $situatie->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $situatie->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $situatie->bonuri->count() }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php $totals = $situatie->getTotals(); @endphp
                                {{ number_format($totals['cantitate_utilizata'], 2) }} L
                            </td>
                            <td class="px-6 py-4 space-x-2 text-sm font-medium whitespace-nowrap">
                                @if ($situatie->status === 'draft')
                                    <button wire:click="finalizeazaSituatie({{ $situatie->id }})"
                                        class="text-green-600 hover:text-green-900">
                                        Finalizează
                                    </button>
                                @endif

                                <button wire:click="manageBonuri({{ $situatie->id }})"
                                    class="text-indigo-600 hover:text-indigo-900">
                                    Gestionează Bonuri
                                </button>

                                <button wire:click="exportPDF({{ $situatie->id }})"
                                    class="text-blue-600 hover:text-blue-900">
                                    Export PDF
                                </button>

                                <livewire:situatie-metadata :situatieId="$situatie->id" :wire:key="'metadata-'.$situatie->id" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="py-12 text-center text-gray-500">
            Nu există situații generate încă.
        </div>
    @endif
</div>
