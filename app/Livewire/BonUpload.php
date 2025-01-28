<?php

namespace App\Livewire;

use App\Models\Bon;
use Livewire\Component;
use App\Models\RezultatOcr;
use App\Services\OcrService;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class BonUpload extends Component
{
    use WithFileUploads;

    public $bon;
    public $message;
    public $rezultateOcr = null;
    public $processing = false;
    public $showEdit = false;
    public $currentBonId = null;

    protected $listeners = ['rezultatUpdated' => 'onRezultatUpdated'];

    public function mount()
    {
        if ($this->currentBonId) {
            $this->rezultateOcr = RezultatOcr::where('bon_id', $this->currentBonId)->first();
            $this->showEdit = true;
        }
    }

    public function save(OcrService $ocrService)
    {
        $this->validate([
            'bon' => 'required|image|max:2048'
        ]);

        try {
            $this->processing = true;

            // Salvăm bonul
            $path = $this->bon->store('bonuri', 'public');
            $bon = Bon::create([
                'imagine_path' => $path,
                'status' => 'processing'
            ]);

            // Procesăm OCR
            $this->rezultateOcr = $ocrService->process($bon);
            $this->currentBonId = $bon->id;
            Log::info('OCR Results:', ['rezultat' => $this->rezultateOcr]);

            $this->message = 'Bon încărcat și procesat cu succes!';
            $bon->update(['status' => 'completed']);
            $this->showEdit = true;
        } catch (\Exception $e) {
            Log::error('Error processing bon:', ['error' => $e->getMessage()]);
            $this->message = 'Eroare: ' . $e->getMessage();
            if (isset($bon)) {
                $bon->update(['status' => 'error']);
            }
        }

        $this->processing = false;
    }

    public function onRezultatUpdated()
    {
        $this->message = 'Rezultatul a fost actualizat cu succes!';
        // Reîncărcăm rezultatele după actualizare
        if ($this->currentBonId) {
            $this->rezultateOcr = RezultatOcr::where('bon_id', $this->currentBonId)->first();
        }
    }

    public function updatedBon($value)
    {
        if ($value instanceof TemporaryUploadedFile) {
            $this->validate([
                'bon' => 'image|max:2048'
            ]);
        }
    }

    public function uploadBon($file)
    {
        if ($file) {
            $this->bon = $file;
        }
    }

    public function render()
    {
        return view('livewire.bon-upload');
    }
}