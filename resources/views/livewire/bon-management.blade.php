<div class="p-6 bg-white rounded-lg shadow">
    <div class="flex justify-between mb-4">
        <h3 class="text-lg font-medium">Gestionare Bonuri</h3>
        <button wire:click="adaugaToateBonurile" 
                class="px-4 py-2 text-white bg-green-500 rounded hover:bg-green-600">
            Adaugă toate bonurile
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        Selectare
                    </th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        Furnizor
                    </th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        Nr. Bon
                    </th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        Data
                    </th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        Cantitate (L)
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($availableBonuri as $bon)
                    <tr>
                        <td class="px-6 py-4">
                            <input type="checkbox" 
                                   wire:click="toggleBon({{ $bon['id'] }})"
                                   @if($bon['is_selected']) checked @endif>
                        </td>
                        <td class="px-6 py-4">{{ $bon['furnizor'] }}</td>
                        <td class="px-6 py-4">{{ $bon['numar_bon'] }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($bon['data_bon'])->format('d.m.Y') }}</td>
                        <td class="px-6 py-4">{{ number_format($bon['cantitate'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>