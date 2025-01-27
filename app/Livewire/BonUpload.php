<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Bon;
use App\Services\OcrService;

class BonUpload extends Component
{
    use WithFileUploads;

    public $bon;
    public $message;
    public $rezultateOcr = null;
    public $processing = false;

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
            
            $this->message = 'Bon încărcat și procesat cu succes!';
            $bon->update(['status' => 'completed']);
            
        } catch (\Exception $e) {
            $this->message = 'Eroare: ' . $e->getMessage();
            if (isset($bon)) {
                $bon->update(['status' => 'error']);
            }
        }

        $this->processing = false;
    }

    public function render()
    {
        return view('livewire.bon-upload');
    }
}