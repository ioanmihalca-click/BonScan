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
    public $showBonManagement = false; // adăugăm această proprietate pentru a controla afișarea componentei de gestionare a bonurilor

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
                session()->flash('warning', 'Nu am găsit niciun bon fiscal în perioada selectată.');
            } else {
                session()->flash('success', 'Situația centralizatoare a fost creată cu succes.');
            }

            // Reîncărcăm lista completă de situații
            $this->loadSituatii();

            // Forțăm reîncărcarea completă a componentei
            $this->dispatch('situatie-generata');
        } catch (\InvalidArgumentException $e) {
            session()->flash('error', $e->getMessage());
        } catch (\Exception $e) {
            session()->flash('error', 'A apărut o eroare la generarea situației.');
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

        return response()->streamDownload(function () use ($pdfService, $situatie) {
            echo $pdfService->generatePdf($situatie)->output();
        }, 'situatie-' . $situatie->perioada . '.pdf');
    }

    public function manageBonuri($situatieId)
    {
        if ($this->situatieCurenta && $this->situatieCurenta->id === $situatieId) {
            // Dacă apăsăm pe aceeași situație, închidem managementul
            $this->situatieCurenta = null;
            $this->showBonManagement = false;
        } else {
            // Dacă apăsăm pe altă situație, o deschidem pe cea nouă
            $this->situatieCurenta = SituatieCentralizatoare::find($situatieId);
            $this->showBonManagement = true;
        }
    }

    public function render()
    {
        return view('livewire.situatii-centralizatoare');
    }
}
