<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Services\PdfExportService;
use App\Models\SituatieCentralizatoare;
use Livewire\Attributes\On;

class SituatiiCentralizatoare extends Component
{
    public $perioada;
    public $situatii;
    public $situatieCurenta = null;
    public $showBonManagement = false;
    public $isProcessing = false;

    public function mount()
    {
        try {
            // Calculăm trimestrul curent bazat pe luna curentă
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            $trimester = ceil($currentMonth / 3);

            // Setăm perioada în formatul corect YYYY-TX
            $this->perioada = $currentYear . '-T' . $trimester;

            $this->loadSituatii();
        } catch (\Exception $e) {
            Log::error('Eroare la inițializarea componentei: ' . $e->getMessage());
            session()->flash('error', 'A apărut o eroare la inițializarea paginii.');
        }
    }

    public function loadSituatii()
    {
        try {
            $this->situatii = SituatieCentralizatoare::with(['bonuri', 'bonuri.rezultatOcr'])
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            if ($this->situatieCurenta) {
                $exists = $this->situatii->contains('id', $this->situatieCurenta->id);
                if (!$exists) {
                    $this->reset(['situatieCurenta', 'showBonManagement']);
                }
            }
        } catch (\Exception $e) {
            Log::error('Eroare la încărcarea situațiilor: ' . $e->getMessage());
            session()->flash('error', 'A apărut o eroare la încărcarea situațiilor.');
        }
    }

    public function genereazaSituatie()
    {
        $this->isProcessing = true;

        try {
            // Verificăm dacă există deja o situație pentru această perioadă
            $existingSituatie = SituatieCentralizatoare::where('perioada', $this->perioada)->first();
            if ($existingSituatie) {
                session()->put('warning', 'Există deja o situație pentru perioada selectată.');
                $this->isProcessing = false;
                return;
            }

            $situatie = SituatieCentralizatoare::generateForPeriod($this->perioada);
            
            if ($situatie->bonuri->isEmpty()) {
                // Ștergem situația goală
                $situatie->delete();
                
                // Notificare utilizator
                session()->put('warning', 'Nu am găsit niciun bon fiscal în perioada selectată.');
            } else {
                session()->put('success', 'Situația centralizatoare a fost creată cu succes și include ' . 
                    $situatie->bonuri->count() . ' bonuri.');
            }

            // Reset stare și reîncărcare indiferent de rezultat
            $this->reset(['situatieCurenta', 'showBonManagement']);
            $this->loadSituatii();
            
        } catch (\InvalidArgumentException $e) {
            session()->put('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Eroare la generarea situației: ' . $e->getMessage());
            session()->put('error', 'A apărut o eroare la generarea situației. Vă rugăm să încercați din nou.');
        } finally {
            $this->isProcessing = false;
            $this->dispatch('refresh-component');
        }
    }

    public function finalizeazaSituatie($situatieId)
    {
        try {
            $situatie = SituatieCentralizatoare::findOrFail($situatieId);
            $situatie->finalize();
            $this->loadSituatii();
            session()->put('success', 'Situația a fost finalizată cu succes.');
            $this->dispatch('situatie-actualizata');
        } catch (\Exception $e) {
            session()->put('error', 'A apărut o eroare la finalizarea situației.');
        }
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
        try {
            if ($this->situatieCurenta && $this->situatieCurenta->id === $situatieId && $this->showBonManagement) {
                $this->situatieCurenta = null;
                $this->showBonManagement = false;
            } else {
                $this->situatieCurenta = SituatieCentralizatoare::findOrFail($situatieId);
                $this->showBonManagement = true;
                $this->dispatch('bon-management-toggle')->to('bon-management');
            }
        } catch (\Exception $e) {
            Log::error('Eroare la deschiderea managementului de bonuri: ' . $e->getMessage());
            session()->flash('error', 'A apărut o eroare la deschiderea managementului de bonuri.');
        }
    }

    #[On('bonuri-actualizate')]
    public function handleBonuriActualizate()
    {
        $this->loadSituatii();
        $this->dispatch('situatie-actualizata')->to('bon-management');
    }

    #[On('refresh-component')]
    public function refreshComponent()
    {
        $this->loadSituatii();
    }

    #[On('remove-warning')]
    public function removeWarning()
    {
        session()->forget('warning');
    }

    public function removeSuccess()
    {
        session()->forget('success');
    }

    public function removeError()
    {
        session()->forget('error');
    }

    public function updated($property)
    {
        if ($property === 'perioada') {
            $this->reset(['situatieCurenta', 'showBonManagement']);
        }
    }

    public function render()
    {
        return view('livewire.situatii-centralizatoare');
    }
}
