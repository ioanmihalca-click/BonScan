<div class="p-6 bg-white rounded-lg shadow">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-medium text-gray-900">Rezultate Procesare</h3>
            <p class="mt-1 text-sm text-gray-500">Verifică și confirmă datele extrase din bon</p>
        </div>
        <button wire:click="toggleEdit" 
                class="inline-flex items-center px-4 py-2 text-sm font-medium transition-colors rounded-md"
                :class="{ 'text-gray-700 bg-gray-100 hover:bg-gray-200': editMode, 'text-white bg-indigo-600 hover:bg-indigo-700': !editMode }">
            {{ $editMode ? 'Anulează' : 'Editează' }}
        </button>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <!-- Preview Bon -->
        <div class="overflow-hidden border rounded-lg bg-gray-50">
            <div class="px-4 py-3 bg-gray-100 border-b">
                <h4 class="font-medium text-gray-900">Bon fiscal</h4>
            </div>
            <div class="p-4">
                <img src="{{ Storage::url($rezultat->bon->imagine_path) }}" 
                     alt="Bon fiscal" 
                     class="object-contain w-full h-auto rounded">
            </div>
        </div>

        <!-- Formularul de editare -->
        <div>
            <form wire:submit="save" class="space-y-4">
                <!-- Furnizor -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Furnizor</label>
                    <input type="text" 
                           wire:model="furnizor" 
                           class="block w-full mt-1 border-gray-300 rounded-md shadow-sm disabled:bg-gray-50"
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
                           class="block w-full mt-1 border-gray-300 rounded-md shadow-sm disabled:bg-gray-50"
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
                           class="block w-full mt-1 border-gray-300 rounded-md shadow-sm disabled:bg-gray-50"
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
                           class="block w-full mt-1 border-gray-300 rounded-md shadow-sm disabled:bg-gray-50"
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
                           class="block w-full mt-1 border-gray-300 rounded-md shadow-sm disabled:bg-gray-50"
                           @readonly(!$editMode)>
                    @error('cantitate_utilizata') 
                        <span class="text-sm text-red-500">{{ $message }}</span> 
                    @enderror
                </div>

                @if($editMode)
                    <div class="flex justify-end space-x-3">
                        <button type="button" 
                                wire:click="toggleEdit"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Anulează
                        </button>
                        <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                            Salvează
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>