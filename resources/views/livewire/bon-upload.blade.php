
<div>
    <form wire:submit="save">
        <div class="space-y-4">
            @if ($message)
                <div class="p-4 bg-green-100 rounded">
                    {{ $message }}
                </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Încarcă bon
                </label>
                <input type="file" wire:model="bon" class="block w-full mt-1" accept="image/*">
                @error('bon') 
                    <span class="text-red-500">{{ $message }}</span> 
                @enderror
            </div>

            <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded" 
                    wire:loading.attr="disabled">
                <span wire:loading.remove>Upload</span>
                <span wire:loading>Se procesează...</span>
            </button>
        </div>
    </form>

    @if($rezultateOcr)
    <div class="mt-8">
        <h3 class="text-lg font-medium">Rezultate OCR:</h3>
        <div class="p-6 mt-4 bg-white rounded-lg shadow">
            <dl class="grid grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Furnizor</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $rezultateOcr->furnizor }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Număr Bon</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $rezultateOcr->numar_bon }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Data</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $rezultateOcr->data_bon }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Cantitate</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $rezultateOcr->cantitate }} L</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Valoare</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $rezultateOcr->valoare }} LEI</dd>
                    </div>
                </dl>
            </div>
        </div>
    @endif
</div>