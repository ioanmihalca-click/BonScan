<?php
namespace App\Services;

use App\Models\CompanyProfile;
use App\Models\SituatieCentralizatoare;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfExportService
{
    public function generatePdf(SituatieCentralizatoare $situatie)
    {
        // Preluăm metadata din profilul companiei
        $companyProfile = CompanyProfile::where('user_id', $situatie->user_id)->first();
        
        // Pregătim datele pentru PDF
        $data = [
            'metadata' => $companyProfile ? $companyProfile->toArray() : [],
            'perioada' => $situatie->perioada,
            'bonuri' => $situatie->bonuri()->with('rezultatOcr')->get(),
            'totals' => $situatie->getTotals()
        ];

        $pdf = PDF::loadView('exports.situatie-centralizatoare', $data);
        
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'DejaVu Sans'
        ]);

        return $pdf;
    }
}