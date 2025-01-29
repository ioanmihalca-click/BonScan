<div>
    @if(!$showBonManagement)
        <button wire:click="$set('showModal', true)" 
                class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm sm:w-auto hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
            </svg>
            <span class="whitespace-nowrap">Editează Date Firmă</span>
        </button>
    @endif

    @if($showModal)
    <div class="fixed inset-0 z-10 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>

            <div class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nume Companie</label>
                        <input type="text" wire:model="metadata.nume_companie" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">CUI/CNP</label>
                        <input type="text" wire:model="metadata.cui_cnp" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">ID APIA</label>
                        <input type="text" wire:model="metadata.id_apia" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Localitate</label>
                        <input type="text" wire:model="metadata.localitate" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Județ</label>
                        <input type="text" wire:model="metadata.judet" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Numele și Prenumele</label>
                        <input type="text" wire:model="metadata.nume_prenume" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Funcție</label>
                        <input type="text" wire:model="metadata.functie" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>

                <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3">
                    <button type="button" 
                            wire:click="$set('showModal', false)"
                            class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none sm:mt-0 sm:text-sm">
                        Anulează
                    </button>
                    <button type="button"
                            wire:click="save"
                            class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none sm:text-sm">
                        Salvează
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>