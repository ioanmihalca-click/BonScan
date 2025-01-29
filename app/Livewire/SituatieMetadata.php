<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SituatieCentralizatoare;

class SituatieMetadata extends Component
{
    public $situatieId;
    public $showModal = false;
    public $showBonManagement = false;
    
    public $metadata = [
        'nume_companie' => 'MIHALCA I. VASILE II',
        'cui_cnp' => '34395231',
        'id_apia' => 'RO008688644',
        'localitate' => 'PETROVA',
        'judet' => 'MARAMUREȘ',
        'nume_prenume' => 'MIHALCA VASILE',
        'functie' => 'administrator'
    ];

    public function mount($situatieId = null, $showBonManagement = false)
    {
        $this->showBonManagement = $showBonManagement;
        
        // Dacă nu avem un ID specific, luăm prima situație disponibilă
        if (!$situatieId) {
            $situatie = SituatieCentralizatoare::first();
            $this->situatieId = $situatie ? $situatie->id : null;
        } else {
            $this->situatieId = $situatieId;
        }

        // Încărcăm metadata dacă avem o situație
        if ($this->situatieId) {
            $situatie = SituatieCentralizatoare::find($this->situatieId);
            if ($situatie && $situatie->metadata) {
                $this->metadata = array_merge($this->metadata, $situatie->metadata);
            }
        }
    }

    public function save()
    {
        if (!$this->situatieId) {
            return;
        }

        $situatie = SituatieCentralizatoare::find($this->situatieId);
        if (!$situatie) {
            return;
        }

        $situatie->update(['metadata' => $this->metadata]);
        
        // Actualizăm metadata pentru toate situațiile
        SituatieCentralizatoare::query()->update(['metadata' => $this->metadata]);
        
        $this->showModal = false;
        $this->dispatch('metadata-updated');
    }

    public function render()
    {
        return view('livewire.situatie-metadata');
    }
}