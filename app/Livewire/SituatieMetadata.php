<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SituatieCentralizatoare;

class SituatieMetadata extends Component
{
    public $situatieId;
    public $showModal = false;
    
    public $metadata = [
        'nume_companie' => 'MIHALCA I. VASILE II',
        'cui_cnp' => '34395231',
        'id_apia' => 'RO008688644',
        'localitate' => 'PETROVA',
        'judet' => 'MARAMUREȘ',
        'nume_prenume' => 'MIHALCA VASILE',
        'functie' => 'administrator'
    ];

    public function mount($situatieId)
    {
        $this->situatieId = $situatieId;
        $situatie = SituatieCentralizatoare::find($situatieId);
        if ($situatie && $situatie->metadata) {
            $this->metadata = array_merge($this->metadata, $situatie->metadata);
        }
    }

    public function save()
    {
        $situatie = SituatieCentralizatoare::find($this->situatieId);
        $situatie->update(['metadata' => $this->metadata]);
        
        $this->showModal = false;
        $this->dispatch('metadata-updated');
    }

    public function render()
    {
        return view('livewire.situatie-metadata');
    }
}