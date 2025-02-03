<?php

namespace App\Livewire;

use App\Models\Bon;
use Livewire\Component;
use App\Jobs\ProcessBonOcr;
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
    public $processingComplete = false;
    public $processingJobs = [];
    public $completedJobs = 0;
    public $totalJobs = 0;

    protected $listeners = [
        'rezultatUpdated' => 'onRezultatUpdated',
        'checkProcessingStatus' => 'checkProcessingStatus'
    ];

    public function mount()
    {
        if ($this->currentBonId) {
            $this->rezultateOcr = RezultatOcr::where('bon_id', $this->currentBonId)->first();
            $this->showEdit = true;
        }
        
        // Inițializăm ascultarea pentru procesare
        $this->dispatch('startProcessingCheck');
    }

    public function save(OcrService $ocrService)
    {
        $this->validate([
            'bonuri.*' => 'required|image|max:5120'
        ]);

        try {
            $this->processing = true;
            $this->rezultateOcr = [];
            $this->completedJobs = 0;
            $this->totalJobs = count($this->bonuri);
            $this->processingJobs = [];

            foreach ($this->bonuri as $bon) {
                $path = $ocrService->optimizeAndStore($bon);
                $bonModel = Bon::create([
                    'imagine_path' => $path,
                    'status' => 'processing',
                    'user_id' => Auth::id()
                ]);

                $this->processingJobs[] = $bonModel->id;
                ProcessBonOcr::dispatch($bonModel);
            }

            $this->message = 'Bonurile au fost încărcate și se procesează...';

        } catch (\Exception $e) {
            Log::error('Error processing bonuri:', ['error' => $e->getMessage()]);
            $this->message = 'Eroare: ' . $e->getMessage();
        }

        $this->processing = false;
        // Forțăm un refresh imediat
        $this->dispatch('checkProcessingStatus');
    }


    public function updatedBonuri($value)
    {
        if ($value) {
            $this->validate([
                'bonuri.*' => 'image|max:5120'
            ]);
        }
    }

    public function checkProcessingStatus()
    {
        Log::info('Checking status', [
            'processingJobs' => $this->processingJobs,
            'totalJobs' => $this->totalJobs,
            'completedJobs' => $this->completedJobs
        ]);

        if (empty($this->processingJobs) || $this->totalJobs === 0) {
            return;
        }

        $completedCount = Bon::whereIn('id', $this->processingJobs)
            ->where('status', 'completed')
            ->count();

        $this->completedJobs = $completedCount;

        if ($this->completedJobs === $this->totalJobs) {
            $this->redirect('/bonuri');
        }

        // Forțăm refresh-ul componentei
        $this->dispatch('$refresh');
    }



    public function onRezultatUpdated()
    {
        if ($this->currentBonId) {
            $this->rezultateOcr = RezultatOcr::where('bon_id', $this->currentBonId)->first();
        }
    }

    public function getProgress()
    {
        if ($this->totalJobs === 0) return 0;
        return ($this->completedJobs / $this->totalJobs) * 100;
    }

    public function render()
    {
        return view('livewire.bon-upload', [
            'progress' => $this->getProgress()
        ]);
    }
}