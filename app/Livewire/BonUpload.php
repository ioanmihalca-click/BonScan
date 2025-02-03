<?php

namespace App\Livewire;

use App\Models\Bon;
use Livewire\Component;
use App\Models\RezultatOcr;
use App\Services\OcrService;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class BonUpload extends Component
{
    use WithFileUploads;

    public $bonuri = [];
    public $message;
    public $rezultateOcr = [];
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
            'bonuri.*' => 'required|image|max:2048'
        ]);
    
        try {
            $this->processing = true;
            $this->rezultateOcr = [];
    
            foreach ($this->bonuri as $bon) {
                // Salvăm bonul cu user_id
                $path = $ocrService->optimizeAndStore($bon);
                $bonModel = Bon::create([
                    'imagine_path' => $path,
                    'status' => 'processing',
                    'user_id' => Auth::id()
                ]);

                // Procesăm OCR
                $rezultat = $ocrService->process($bonModel);
                $this->rezultateOcr[] = $rezultat;
                $bonModel->update(['status' => 'completed']);
            }

            $this->message = count($this->bonuri) . ' bonuri au fost încărcate și procesate cu succes!';
            $this->showEdit = true;
            $this->bonuri = []; // Reset după procesare

        } catch (\Exception $e) {
            Log::error('Error processing bonuri:', ['error' => $e->getMessage()]);
            $this->message = 'Eroare: ' . $e->getMessage();
        }

        $this->processing = false;
    }

    public function onRezultatUpdated()
    {
        $this->message = 'Rezultatul a fost actualizat cu succes!';
        if ($this->currentBonId) {
            $this->rezultateOcr = RezultatOcr::where('bon_id', $this->currentBonId)->first();
        }
    }

    public function updatedBonuri($value)
    {
        if ($value) {
            $this->validate([
                'bonuri.*' => 'image|max:2048'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.bon-upload');
    }
}