<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\RezultatOcr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class EditRezultatOcr extends Component
{
    public RezultatOcr $rezultat;
    public $furnizor;
    public $numar_bon;
    public $data_bon;
    public $cantitate_facturata;
    public $cantitate_utilizata;
    public $editMode = false;
    
    protected $rules = [
        'furnizor' => 'required|string|min:3',
        'numar_bon' => 'required|string',
        'data_bon' => 'required|date',
        'cantitate_facturata' => 'required|numeric|min:0',
        'cantitate_utilizata' => 'required|numeric|min:0'
    ];

    public function mount(RezultatOcr $rezultat)
    {
        $this->rezultat = $rezultat;
        $this->loadRezultat();
    }

    public function loadRezultat()
    {
        $this->furnizor = $this->rezultat->furnizor;
        $this->numar_bon = $this->rezultat->numar_bon;
        $this->data_bon = Carbon::parse($this->rezultat->data_bon)->format('Y-m-d');
        $this->cantitate_facturata = $this->rezultat->cantitate_facturata;
        $this->cantitate_utilizata = $this->rezultat->cantitate_utilizata;
    }

    public function toggleEdit()
    {
        $this->editMode = !$this->editMode;
        if (!$this->editMode) {
            $this->loadRezultat(); // Reset la valorile originale când anulăm editarea
        }
    }

    public function save()
    {
        $this->validate();

        $this->rezultat->update([
            'furnizor' => $this->furnizor,
            'numar_bon' => $this->numar_bon,
            'data_bon' => $this->data_bon,
            'cantitate_facturata' => $this->cantitate_facturata,
            'cantitate_utilizata' => $this->cantitate_utilizata,
            'verified_at' => now()
        ]);

        $this->editMode = false;
        $this->dispatch('rezultatUpdated');
    }

    public function render()
    {
        return view('livewire.edit-rezultat-ocr');
    }
}