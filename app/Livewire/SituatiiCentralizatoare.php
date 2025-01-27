<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SituatieCentralizatoare;
use Illuminate\Support\Carbon;

class SituatiiCentralizatoare extends Component
{
    public $perioada;
    public $situatii;
    public $situatieCurenta = null;
    
    public function mount()
    {
        $this->perioada = Carbon::now()->format('Y-m');
        $this->loadSituatii();
    }

    public function loadSituatii()
    {
        $this->situatii = SituatieCentralizatoare::orderBy('created_at', 'desc')
            ->take(10)
            ->get();
    }

    public function genereazaSituatie()
    {
        $this->situatieCurenta = SituatieCentralizatoare::generateForPeriod($this->perioada);
        $this->loadSituatii();
    }

    public function finalizeazaSituatie($situatieId)
    {
        $situatie = SituatieCentralizatoare::findOrFail($situatieId);
        $situatie->finalize();
        $this->loadSituatii();
    }

    public function exportPDF($situatieId)
    {
        // TODO: Implementare export PDF
    }

    public function render()
    {
        return view('livewire.situatii-centralizatoare');
    }
}