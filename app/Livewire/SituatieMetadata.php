<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\SituatieCentralizatoare;

class SituatieMetadata extends Component
{
    public $situatieId;
    public $showModal = false;
    public $showBonManagement = false;

    // Vom încărca metadata din profilul utilizatorului sau vom folosi valori default
    public $metadata = [
        'nume_companie' => '',
        'cui_cnp' => '',
        'id_apia' => '',
        'localitate' => '',
        'judet' => '',
        'nume_prenume' => '',
        'functie' => ''
    ];

    protected $listeners = ['metadata-updated' => '$refresh'];

    public function showMessage($type, $message)
    {
        session()->flash($type, $message);
    }

    public function mount($situatieId = null, $showBonManagement = false)
    {
        $this->showBonManagement = $showBonManagement;

        // Dacă nu avem un ID specific, luăm prima situație disponibilă a utilizatorului
        if (!$situatieId) {
            $situatie = SituatieCentralizatoare::where('user_id', Auth::id())
                ->first();
            $this->situatieId = $situatie ? $situatie->id : null;
        } else {
            // Verificăm dacă situația aparține utilizatorului
            $situatie = SituatieCentralizatoare::where('user_id', Auth::id())
                ->find($situatieId);
            $this->situatieId = $situatie ? $situatie->id : null;
        }

        // Încărcăm metadata din ultima situație a utilizatorului
        $lastSituatie = SituatieCentralizatoare::where('user_id', Auth::id())
            ->whereNotNull('metadata')
            ->latest()
            ->first();

        if ($lastSituatie && $lastSituatie->metadata) {
            $this->metadata = array_merge($this->metadata, $lastSituatie->metadata);
        }
    }

    public function save()
    {
        try {
            // Pentru debugging
            logger('Save method called with metadata:', $this->metadata);

            // Actualizăm metadata pentru toate situațiile utilizatorului curent
            SituatieCentralizatoare::where('user_id', Auth::id())
                ->update(['metadata' => $this->metadata]);

            $this->showModal = false;
            $this->dispatch('metadata-updated');
            session()->flash('success', 'Datele au fost salvate cu succes.');
        } catch (\Exception $e) {
            logger('Error in save method:', ['error' => $e->getMessage()]);
            session()->flash('error', 'A apărut o eroare la salvarea datelor: ' . $e->getMessage());
        }
    }

    // Metodă helper pentru a verifica dacă metadata este completă
    public function isMetadataComplete()
    {
        return !empty($this->metadata['nume_companie']) &&
            !empty($this->metadata['cui_cnp']) &&
            !empty($this->metadata['id_apia']) &&
            !empty($this->metadata['localitate']) &&
            !empty($this->metadata['judet']) &&
            !empty($this->metadata['nume_prenume']) &&
            !empty($this->metadata['functie']);
    }

    public function render()
    {
        return view('livewire.situatie-metadata', [
            'isComplete' => $this->isMetadataComplete()
        ]);
    }
}
