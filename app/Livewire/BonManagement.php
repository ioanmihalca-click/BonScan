<?php

namespace App\Livewire;

use App\Models\Bon;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\SituatieCentralizatoare;
use Livewire\Attributes\On;

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

    #[On('bon-management-toggle')]
    public function handleBonManagementToggle()
    {
        $this->loadAvailableBonuri();
    }

    #[On('situatie-actualizata')]
    public function handleSituatieActualizata()
    {
        $this->loadAvailableBonuri();
    }

    public function toggleBon($bonId)
    {
        try {
            $situatie = SituatieCentralizatoare::find($this->situatieId);
            if (!$situatie) {
                $this->dispatch('showMessage', type: 'error', message: 'Situația nu a fost găsită.');
                return;
            }

            // Găsim bonul în lista disponibilă
            $bon = collect($this->availableBonuri)->firstWhere('id', $bonId);
            if (!$bon) {
                $this->dispatch('showMessage', type: 'error', message: 'Bonul nu a fost găsit.');
                return;
            }

            if ($bon['is_selected']) {
                $situatie->bonuri()->detach($bonId);
                $this->dispatch('showMessage', type: 'success', message: 'Bonul a fost eliminat din situație.');
            } else {
                $situatie->bonuri()->attach($bonId);
                $this->dispatch('showMessage', type: 'success', message: 'Bonul a fost adăugat la situație.');
            }

            $this->loadAvailableBonuri();
            $this->dispatch('bonuri-actualizate')->to('situatii-centralizatoare');
        } catch (\Exception $e) {
            Log::error('Eroare la toggle bon: ' . $e->getMessage());
            $this->dispatch('showMessage', type: 'error', message: 'A apărut o eroare la procesarea bonului.');
        }
    }

    public function adaugaToateBonurile()
    {
        try {
            $situatie = SituatieCentralizatoare::find($this->situatieId);
            if (!$situatie) {
                $this->dispatch('showMessage', type: 'error', message: 'Situația nu a fost găsită.');
                return;
            }

            $bonuriDeAdaugat = collect($this->availableBonuri)
                ->filter(function($bon) {
                    return !$bon['is_selected'];
                })
                ->pluck('id')
                ->toArray();
            
            if (empty($bonuriDeAdaugat)) {
                $this->dispatch('showMessage', type: 'info', message: 'Toate bonurile sunt deja adăugate la situație.');
                return;
            }

            $situatie->bonuri()->attach($bonuriDeAdaugat);
            $this->loadAvailableBonuri();
            
            $this->dispatch('showMessage', type: 'success', message: count($bonuriDeAdaugat) . ' bonuri au fost adăugate cu succes.');
            $this->dispatch('bonuri-actualizate')->to('situatii-centralizatoare');
        } catch (\Exception $e) {
            Log::error('Eroare la adăugarea tuturor bonurilor: ' . $e->getMessage());
            $this->dispatch('showMessage', type: 'error', message: 'A apărut o eroare la adăugarea bonurilor.');
        }
    }

    public function render()
    {
        return view('livewire.bon-management');
    }
}
