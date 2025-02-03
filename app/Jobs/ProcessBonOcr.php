<?php

namespace App\Jobs;

use App\Models\Bon;
use App\Services\OcrService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessBonOcr implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $bon;

    public function __construct(Bon $bon)
    {
        $this->bon = $bon;
    }

    public function handle(OcrService $ocrService)
    {
        try {
            $rezultat = $ocrService->process($this->bon);
            $this->bon->update(['status' => 'completed']);
        } catch (\Exception $e) {
            $this->bon->update(['status' => 'failed']);
            throw $e;
        }
    }
}