<?php

namespace App\Livewire;

use App\Models\Bon;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\SituatieCentralizatoare;

class BonManagement extends Component
{
    public $situatieId;
    public $searchTerm = '';
    public $selectedBonuri = [];
    public $availableBonuri = [];

    public function mount($situatieId)
    {
        $this->situatieId = $situatieId;
        $this->loadAvailableBonuri();
    }

    public function loadAvailableBonuri()
    {
        $situatie = SituatieCentralizatoare::find($this->situatieId);

        // Extragem anul și trimestrul (e.g., "2024-T1")
        [$year, $trimester] = explode('-T', $situatie->perioada);

        // Determinăm lunile pentru trimestrul respectiv
        switch ($trimester) {
            case '1':
                $startMonth = 1;
                $endMonth = 4;
                break;
            case '2':
                $startMonth = 5;
                $endMonth = 8;
                break;
            case '3':
                $startMonth = 9;
                $endMonth = 12;
                break;
        }

        // Găsim bonurile pentru trimestrul respectiv
        $this->availableBonuri = Bon::whereHas('rezultatOcr', function ($query) use ($year, $startMonth, $endMonth) {
            $query->whereYear('data_bon', $year)
                ->whereMonth('data_bon', '>=', $startMonth)
                ->whereMonth('data_bon', '<=', $endMonth);
        })
            ->with('rezultatOcr')
            ->get()
            ->map(function ($bon) use ($situatie) {
                return [
                    'id' => $bon->id,
                    'furnizor' => $bon->rezultatOcr->furnizor,
                    'numar_bon' => $bon->rezultatOcr->numar_bon,
                    'data_bon' => $bon->rezultatOcr->data_bon,
                    'cantitate' => $bon->rezultatOcr->cantitate_facturata,
                    'is_selected' => $situatie->bonuri->contains($bon->id)
                ];
            })
            ->toArray();
    }

    public function toggleBon($bonId)
    {
        $situatie = SituatieCentralizatoare::find($this->situatieId);

        if (in_array($bonId, $this->selectedBonuri)) {
            // Dacă bonul e deja selectat, îl eliminăm
            $situatie->bonuri()->detach($bonId);
            $this->selectedBonuri = array_diff($this->selectedBonuri, [$bonId]);
        } else {
            // Dacă bonul nu e selectat, îl adăugăm
            $situatie->bonuri()->attach($bonId);
            $this->selectedBonuri[] = $bonId;
        }

        $this->loadAvailableBonuri();
    }

    public function adaugaToateBonurile()
    {
        $situatie = SituatieCentralizatoare::find($this->situatieId);
        $bonIds = collect($this->availableBonuri)->pluck('id');
        $situatie->bonuri()->syncWithoutDetaching($bonIds);
        $this->loadAvailableBonuri();
    }

    public function render()
    {
        return view('livewire.bon-management');
    }
}
