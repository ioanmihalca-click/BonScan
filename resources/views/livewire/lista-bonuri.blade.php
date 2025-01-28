<div class="p-6 bg-white rounded-lg shadow">
    <!-- Header -->
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900">Bonuri Fiscale</h1>
            <p class="mt-2 text-sm text-gray-700">Lista tuturor bonurilor scanate și procesate</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <a href="/" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700">
                Adaugă Bon Nou
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="flex flex-col mt-8">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle">
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
        </div>
    </div>

    <div class="mt-4">
        {{ $bonuri->links() }}
    </div>

 <!-- Modal de confirmare ștergere -->
    @if($showDeleteModal)
    <div class="fixed inset-0 z-50 transition-opacity bg-gray-500 bg-opacity-75">
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
                <div class="relative px-4 pt-5 pb-4 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                    <div class="sm:flex sm:items-start">
                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">Confirmare ștergere</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Ești sigur că vrei să ștergi acest bon? Această acțiune nu poate fi anulată.</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                        <button wire:click="deleteBon" type="button" class="inline-flex justify-center w-full px-3 py-2 text-sm font-semibold text-white bg-red-600 rounded-md shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
                            Șterge
                        </button>
                        <button wire:click="$set('showDeleteModal', false)" type="button" class="inline-flex justify-center w-full px-3 py-2 mt-3 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                            Anulează
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal de editare -->
    @if($showEditModal)
    <div class="fixed inset-0 z-50 transition-opacity bg-gray-500 bg-opacity-75">
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
                <div class="relative px-4 pt-5 pb-4 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                    <div class="absolute top-0 right-0 pt-4 pr-4">
                        <button wire:click="$set('showEditModal', false)" type="button" class="text-gray-400 bg-white rounded-md hover:text-gray-500">
                            <span class="sr-only">Close</span>
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:text-left">
                        <h3 class="text-base font-semibold leading-6 text-gray-900">Editare Bon</h3>
                        <div class="mt-4">
                            <livewire:edit-rezultat-ocr :rezultat="App\Models\RezultatOcr::where('bon_id', $selectedBonId)->first()" :wire:key="'edit-'.$selectedBonId" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>