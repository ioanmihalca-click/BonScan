<?php

namespace App\Services;

use App\Models\SituatieCentralizatoare;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfExportService
{
    public function generatePdf(SituatieCentralizatoare $situatie)
    {
        // Pregătim datele pentru PDF
        $data = [
            'metadata' => $situatie->metadata ?? [],
            'perioada' => $situatie->perioada,
            'bonuri' => $situatie->bonuri()->with('rezultatOcr')->get(),
            'totals' => $situatie->getTotals()
        ];

        // Generăm PDF-ul folosind template-ul blade
        $pdf = PDF::loadView('exports.situatie-centralizatoare', $data);
        
        // Configurăm PDF-ul
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'DejaVu Sans'
        ]);

        return $pdf;
    }

    public function streamPdf(SituatieCentralizatoare $situatie)
    {
        return $this->generatePdf($situatie)->stream('situatie-' . $situatie->perioada . '.pdf');
    }

    public function savePdf(SituatieCentralizatoare $situatie, $path = null)
    {
        if (!$path) {
            $path = storage_path('app/public/situatii/situatie-' . $situatie->perioada . '.pdf');
        }
        
        $this->generatePdf($situatie)->save($path);
        return $path;
    }
}