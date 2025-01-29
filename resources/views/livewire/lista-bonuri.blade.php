<div class="p-4 bg-white rounded-lg shadow md:p-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div class="flex-1 min-w-0">
            <h1 class="text-xl font-semibold text-gray-900">Bonuri Fiscale</h1>
            <p class="mt-2 text-sm text-gray-700">Lista tuturor bonurilor scanate și procesate</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="/" class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm sm:w-auto hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Adaugă Bon Nou
            </a>
        </div>
    </div>

    <!-- Table pentru Desktop / Cards pentru Mobile -->
    <div class="mt-8">
        <!-- Desktop Table -->
        <div class="hidden md:block">
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Data Bon</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Furnizor</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Nr. Bon</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Cantitate (L)</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4">
                                <span class="sr-only">Acțiuni</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($bonuri as $bon)
                            <tr>
                                <td class="py-4 pl-4 pr-3 text-sm text-gray-900">
                                    {{ optional($bon->rezultatOcr)->data_bon ? Carbon\Carbon::parse($bon->rezultatOcr->data_bon)->format('d.m.Y') : 'N/A' }}
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-900">
                                    {{ optional($bon->rezultatOcr)->furnizor ?? 'N/A' }}
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-900">
                                    {{ optional($bon->rezultatOcr)->numar_bon ?? 'N/A' }}
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-900">
                                    {{ optional($bon->rezultatOcr)->cantitate_facturata ? number_format($bon->rezultatOcr->cantitate_facturata, 2) : 'N/A' }}
                                </td>
                                <td class="px-3 py-4 text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $bon->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                           ($bon->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $bon->status }}
                                    </span>
                                </td>
                                <td class="py-4 pl-3 pr-4 text-sm text-right">
                                    <div class="flex justify-end gap-2">
                                        <button wire:click="editBon({{ $bon->id }})" 
                                                class="text-indigo-600 hover:text-indigo-900">
                                            Editează
                                        </button>
                                        <button wire:click="confirmDelete({{ $bon->id }})" 
                                                class="text-red-600 hover:text-red-900">
                                            Șterge
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Cards -->
        <div class="space-y-4 md:hidden">
            @foreach ($bonuri as $bon)
                <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow">
                    <div class="p-4 space-y-3">
                        <!-- Header cu Data și Status -->
                        <div class="flex items-center justify-between">
                            <div class="text-sm font-medium text-gray-900">
                                {{ optional($bon->rezultatOcr)->data_bon ? Carbon\Carbon::parse($bon->rezultatOcr->data_bon)->format('d.m.Y') : 'N/A' }}
                            </div>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $bon->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                   ($bon->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $bon->status }}
                            </span>
                        </div>

                        <!-- Detalii Bon -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <div class="text-xs text-gray-500">Furnizor</div>
                                <div class="text-sm font-medium text-gray-900">
                                    {{ optional($bon->rezultatOcr)->furnizor ?? 'N/A' }}
                                </div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500">Nr. Bon</div>
                                <div class="text-sm font-medium text-gray-900">
                                    {{ optional($bon->rezultatOcr)->numar_bon ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="col-span-2">
                                <div class="text-xs text-gray-500">Cantitate</div>
                                <div class="text-sm font-medium text-gray-900">
                                    {{ optional($bon->rezultatOcr)->cantitate_facturata ? number_format($bon->rezultatOcr->cantitate_facturata, 2) : 'N/A' }} L
                                </div>
                            </div>
                        </div>

                        <!-- Butoane Acțiuni -->
                        <div class="flex justify-end gap-2 pt-2 border-t border-gray-200">
                            <button wire:click="editBon({{ $bon->id }})" 
                                class="inline-flex items-center px-3 py-1.5 text-sm text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Editează
                            </button>
                            <button wire:click="confirmDelete({{ $bon->id }})" 
                                class="inline-flex items-center px-3 py-1.5 text-sm text-white bg-red-600 rounded-md hover:bg-red-700">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Șterge
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Paginare -->
    <div class="mt-4">
        {{ $bonuri->links() }}
    </div>

   <!-- Modal de Ștergere -->
@if($showDeleteModal)
<div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div class="sm:flex sm:items-start">
                <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                        Confirmare ștergere
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            Ești sigur că vrei să ștergi acest bon? Această acțiune nu poate fi anulată.
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                <button wire:click="deleteBon" type="button" 
                    class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md shadow-sm hover:bg-red-700 sm:ml-3 sm:w-auto">
                    Șterge
                </button>
                <button wire:click="$set('showDeleteModal', false)" type="button" 
                    class="inline-flex justify-center w-full px-4 py-2 mt-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto">
                    Anulează
                </button>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Modal de Editare -->
@if($showEditModal)
<div class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block w-full overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="absolute top-0 right-0 pt-4 pr-4">
                <button wire:click="$set('showEditModal', false)" type="button" 
                    class="text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <span class="sr-only">Închide</span>
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="px-4 pt-5 pb-4 sm:p-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Editare Bon</h3>
                <div class="mt-4">
                    <livewire:edit-rezultat-ocr 
                        :rezultat="App\Models\RezultatOcr::where('bon_id', $selectedBonId)->first()" 
                        :wire:key="'edit-'.$selectedBonId" />
                </div>
            </div>
        </div>
    </div>
</div>
@endif