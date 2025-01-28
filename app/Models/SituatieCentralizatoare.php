<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SituatieCentralizatoare extends Model
{
    use HasFactory;

    protected $table = 'situatii_centralizatoare';

    protected $fillable = [
        'perioada',
        'status',
        'metadata',
        'generated_at',
        'finalized_at'
    ];

    protected $casts = [
        'metadata' => 'array',
        'generated_at' => 'datetime',
        'finalized_at' => 'datetime'
    ];

    // Relație multe-la-multe cu bonurile
    public function bonuri()
    {
        return $this->belongsToMany(Bon::class, 'situatie_bon', 'situatie_id', 'bon_id')
            ->withTimestamps();
    }

    // Metodă pentru a genera situația pentru o anumită perioadă
    public static function generateForPeriod($perioada)
    {
        // Perioada va fi în format "2024-T1", "2024-T2" sau "2024-T3"
        $situatie = self::create([
            'perioada' => $perioada,
            'status' => 'draft',
            'generated_at' => now()
        ]);

        // Extragem anul și trimestrul
        [$year, $trimester] = explode('-T', $perioada);

        // Determinăm lunile pentru trimestrul respectiv
        switch ($trimester) {
            case '1':
                $startMonth = 1;
                $endMonth = 4;
                break;
            case '2':
                $startMonth = 5;
                $endMonth = 8;
                break;
            case '3':
                $startMonth = 9;
                $endMonth = 12;
                break;
        }

        // Găsim toate bonurile din trimestrul respectiv
        $bonuri = Bon::whereHas('rezultatOcr', function ($query) use ($year, $startMonth, $endMonth) {
            $query->whereYear('data_bon', $year)
                ->whereMonth('data_bon', '>=', $startMonth)
                ->whereMonth('data_bon', '<=', $endMonth);
        })->get();

        // Atașăm bonurile la situație
        $situatie->bonuri()->attach($bonuri->pluck('id'));

        return $situatie;
    }

    // Metodă pentru a finaliza situația
    public function finalize()
    {
        $this->update([
            'status' => 'finalized',
            'finalized_at' => now()
        ]);
    }

    // Metodă pentru a obține totalurile
    public function getTotals()
    {
        $totals = [
            'cantitate_facturata' => 0,
            'cantitate_utilizata' => 0,
            'bonuri_count' => 0
        ];

        foreach ($this->bonuri as $bon) {
            if ($rezultat = $bon->rezultatOcr) {
                $totals['cantitate_facturata'] += $rezultat->cantitate_facturata;
                $totals['cantitate_utilizata'] += $rezultat->cantitate_utilizata;
                $totals['bonuri_count']++;
            }
        }

        return $totals;
    }

    public function setMetadata(array $data)
    {
        $this->metadata = array_merge($this->metadata ?? [], $data);
        $this->save();
    }

    public function getDefaultMetadata()
    {
        return [
            'nume_companie' => 'MIHALCA I. VASILE II',
            'cui_cnp' => '34395231',
            'id_apia' => 'RO008688644',
            'localitate' => 'PETROVA',
            'judet' => 'MARAMUREȘ',
            'nume_prenume' => 'MIHALCA VASILE'
        ];
    }
}
