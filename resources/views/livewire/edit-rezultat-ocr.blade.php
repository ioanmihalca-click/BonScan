<div class="p-6 bg-white rounded-lg shadow">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-medium">Rezultate OCR</h3>
        <button wire:click="toggleEdit" class="px-4 py-2 text-sm font-medium rounded-md" :class="{ 'bg-gray-200': editMode, 'bg-blue-500 text-white': !editMode }">
            {{ $editMode ? 'Anulează' : 'Editează' }}
        </button>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <!-- Preview Bon -->
        <div class="p-4 border rounded-lg">
            <h4 class="mb-2 font-medium">Bon fiscal</h4>
            <img src="{{ Storage::url($rezultat->bon->imagine_path) }}" 
                 alt="Bon fiscal" 
                 class="h-auto max-w-full rounded">
        </div>

        <!-- Formularul de editare -->
        <div>
            <form wire:submit="save" class="space-y-4">
                <!-- Furnizor -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Furnizor</label>
                    <input type="text" 
                           wire:model="furnizor" 
                           class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                           @readonly(!$editMode)>
                    @error('furnizor') 
                        <span class="text-sm text-red-500">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Număr Bon -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Număr Bon</label>
                    <input type="text" 
                           wire:model="numar_bon" 
                           class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                           @readonly(!$editMode)>
                    @error('numar_bon') 
                        <span class="text-sm text-red-500">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Data Bon -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Data</label>
                    <input type="date" 
                           wire:model="data_bon" 
                           class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                           @readonly(!$editMode)>
                    @error('data_bon') 
                        <span class="text-sm text-red-500">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Cantitate Facturată -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Cantitate facturată (L)</label>
                    <input type="number" 
                           wire:model="cantitate_facturata" 
                           step="0.01"
                           class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                           @readonly(!$editMode)>
                    @error('cantitate_facturata') 
                        <span class="text-sm text-red-500">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Cantitate Utilizată -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Cantitate utilizată (L)</label>
                    <input type="number" 
                           wire:model="cantitate_utilizata" 
                           step="0.01"
                           class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                           @readonly(!$editMode)>
                    @error('cantitate_utilizata') 
                        <span class="text-sm text-red-500">{{ $message }}</span> 
                    @enderror
                </div>

                @if($editMode)
                    <div class="flex justify-end space-x-4">
                        <button type="button" 
                                wire:click="toggleEdit"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                            Anulează
                        </button>
                        <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600">
                            Salvează
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>