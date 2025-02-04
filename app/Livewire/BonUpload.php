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
    public $showEditModal = false;
    public $selectedBonId = null;

    protected $listeners = [
        'rezultatUpdated' => 'onRezultatUpdated',
        'checkProcessingStatus' => 'checkProcessingStatus',
        'resetProcessingState' => 'resetProcessingState',
        'startProcessingCheck' => 'checkProcessingStatus'
    ];

    public function mount()
    {
        if ($this->currentBonId) {
            $this->rezultateOcr = RezultatOcr::where('bon_id', $this->currentBonId)->first();
            $this->showEdit = true;
        }
        
        $this->dispatch('startProcessingCheck');
    }

    public function save(OcrService $ocrService)
{
    $this->validate([
        'bonuri.*' => 'required|image|max:5120'
    ]);

    try {
        // Reset states first
        $this->resetProcessingState();
        
        // Initialize processing state
        $this->processing = true;
        $this->processingComplete = false;
        $this->totalJobs = count($this->bonuri);
        Log::info('Starting processing', ['totalJobs' => $this->totalJobs]);

        foreach ($this->bonuri as $bon) {
            $path = $ocrService->optimizeAndStore($bon);
            $bonModel = Bon::create([
                'imagine_path' => $path,
                'user_id' => Auth::id(),
                'status' => 'processing'
            ]);

            $this->processingJobs[] = $bonModel->id;
            ProcessBonOcr::dispatch($bonModel);
        }

        $this->message = 'Bonurile au fost încărcate și se procesează...';
        $this->dispatch('startProcessingCheck');

    } catch (\Exception $e) {
        Log::error('Error processing bonuri:', ['error' => $e->getMessage()]);
        $this->message = 'Eroare: ' . $e->getMessage();
    }

    $this->processing = false;
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
    if (empty($this->processingJobs)) {
        Log::info('No processing jobs to check');
        return;
    }

    Log::info('Checking processing status', [
        'jobs' => $this->processingJobs,
        'completed' => $this->completedJobs,
        'total' => $this->totalJobs
    ]);

    $completedCount = Bon::whereIn('id', $this->processingJobs)
        ->where('status', 'completed')
        ->count();

    $this->completedJobs = $completedCount;

    if ($this->completedJobs === $this->totalJobs) {
        Log::info('Processing complete');
        $this->processingComplete = true;
        $this->dispatch('processingComplete');
        $this->dispatch('bonuriUpdated');
        $this->message = 'Toate bonurile au fost procesate cu succes!';
        
        // Clear uploaded files but keep processing state visible
        $this->bonuri = [];
    }
}

public function resetProcessingState()
{
    Log::info('Resetting processing state');
    $this->processingJobs = [];
    $this->totalJobs = 0;
    $this->completedJobs = 0;
    $this->processingComplete = false;
    $this->processing = false;
}

    public function editBon($bonId)
    {
        $this->selectedBonId = $bonId;
        $this->showEditModal = true;
    }

    public function onRezultatUpdated()
    {
        if ($this->currentBonId) {
            $this->rezultateOcr = RezultatOcr::where('bon_id', $this->currentBonId)->first();
        }
        $this->dispatch('bonuriUpdated');  
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