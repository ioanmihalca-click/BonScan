<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Carbon;
use App\Services\PdfExportService;
use App\Models\SituatieCentralizatoare;

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
        $situatie = SituatieCentralizatoare::findOrFail($situatieId);
        $pdfService = app(PdfExportService::class);
        
        return response()->streamDownload(function() use ($pdfService, $situatie) {
            echo $pdfService->generatePdf($situatie)->output();
        }, 'situatie-' . $situatie->perioada . '.pdf');
    }

    public function manageBonuri($situatieId)
    {
        $this->situatieCurenta = SituatieCentralizatoare::find($situatieId);
        $this->dispatch('showBonManagement', situatieId: $situatieId);
    }

    public function render()
    {
        return view('livewire.situatii-centralizatoare');
    }
}