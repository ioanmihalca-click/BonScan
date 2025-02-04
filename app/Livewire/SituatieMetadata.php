<?php
// app/Livewire/SituatieMetadata.php
namespace App\Livewire;

use App\Models\CompanyProfile;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SituatieMetadata extends Component
{
    public $showModal = false;
    public $showBonManagement = false;

    public $metadata = [
        'nume_companie' => '',
        'cui_cnp' => '',
        'id_apia' => '',
        'localitate' => '',
        'judet' => '',
        'nume_prenume' => '',
        'functie' => ''
    ];

    public function mount($situatieId = null, $showBonManagement = false)
    {
        $this->showBonManagement = $showBonManagement;

        // Încărcăm metadata din profilul companiei
        $profile = CompanyProfile::firstOrCreate(
            ['user_id' => Auth::id()],
            []
        );

        // Preluăm doar câmpurile care ne interesează
        foreach ($this->metadata as $key => $value) {
            if (isset($profile->$key)) {
                $this->metadata[$key] = $profile->$key;
            }
        }
    }

    public function save()
    {
        try {
            $profile = CompanyProfile::updateOrCreate(
                ['user_id' => Auth::id()],
                $this->metadata
            );

            $this->showModal = false;
            $this->dispatch('metadata-updated');
            session()->flash('success', 'Datele au fost salvate cu succes.');
        } catch (\Exception $e) {
            logger('Error in save method:', ['error' => $e->getMessage()]);
            session()->flash('error', 'A apărut o eroare la salvarea datelor: ' . $e->getMessage());
        }
    }

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