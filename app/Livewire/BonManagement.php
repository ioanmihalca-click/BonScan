<?php

namespace App\Livewire;

use App\Models\Bon;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
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
        $situatie = SituatieCentralizatoare::where('user_id', Auth::id())
            ->findOrFail($this->situatieId);

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
        $this->availableBonuri = Bon::where('user_id', Auth::id())
            ->whereHas('rezultatOcr', function ($query) use ($year, $startMonth, $endMonth) {
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
        // Verificăm dacă situația aparține utilizatorului
        $situatie = SituatieCentralizatoare::where('user_id', Auth::id())
            ->findOrFail($this->situatieId);

        // Verificăm dacă bonul aparține utilizatorului
        $bon = Bon::where('user_id', Auth::id())
            ->findOrFail($bonId);

        // Găsim bonul în lista disponibilă pentru a verifica statusul
        $bonInLista = collect($this->availableBonuri)->firstWhere('id', $bonId);
        if (!$bonInLista) {
            $this->dispatch('showMessage', type: 'error', message: 'Bonul nu a fost găsit în lista disponibilă.');
            return;
        }

        if ($bonInLista['is_selected']) {
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
                ->filter(function ($bon) {
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
