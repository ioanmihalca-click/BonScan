<div>
    <form wire:submit="save">
        <div class="space-y-4">
            @if ($message)
                <div class="p-4 mb-4 bg-green-100 rounded">
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

    @if($showEdit && $rezultateOcr)
        <div class="mt-8">
            <livewire:edit-rezultat-ocr :rezultat="$rezultateOcr" :wire:key="'edit-'.$rezultateOcr->id" />
        </div>
    @endif
</div>