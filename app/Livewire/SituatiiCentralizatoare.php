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
        // Calculăm trimestrul curent bazat pe luna curentă
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $trimester = ceil($currentMonth / 3);
        
        // Setăm perioada în formatul corect YYYY-TX
        $this->perioada = $currentYear . '-T' . $trimester;
        
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
        try {
            $this->situatieCurenta = SituatieCentralizatoare::generateForPeriod($this->perioada);
            
            if ($this->situatieCurenta->bonuri->isEmpty()) {
                session()->flash('warning', 'Nu am găsit niciun bon fiscal în perioada selectată. Vă rugăm să verificați dacă ați scanat bonurile pentru această perioadă.');
            } else {
                session()->flash('success', 'Situația centralizatoare a fost creată cu succes și include toate bonurile din perioada selectată.');
            }
            
            $this->loadSituatii();
        } catch (\InvalidArgumentException $e) {
            session()->flash('error', $e->getMessage());
        } catch (\Exception $e) {
            session()->flash('error', 'Ne pare rău, dar a apărut o problemă la generarea situației. Vă rugăm să încercați din nou sau să contactați administratorul dacă problema persistă.');
        }
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