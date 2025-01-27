<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Bon;
use App\Services\OcrService;
use Illuminate\Support\Facades\Log;

class BonUpload extends Component
{
    use WithFileUploads;

    public $bon;
    public $message;
    public $rezultateOcr = null;
    public $processing = false;
    public $showEdit = false;

    protected $listeners = ['rezultatUpdated' => 'onRezultatUpdated'];

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
    }

    public function render()
    {
        return view('livewire.bon-upload');
    }
}