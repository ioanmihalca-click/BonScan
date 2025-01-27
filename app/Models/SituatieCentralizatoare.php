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
        $situatie = self::create([
            'perioada' => $perioada,
            'status' => 'draft',
            'generated_at' => now()
        ]);

        // Găsim toate bonurile din perioada respectivă
        $bonuri = Bon::whereHas('rezultatOcr', function ($query) use ($perioada) {
            // Presupunem că perioada este în format 'YYYY-MM'
            $query->whereRaw("DATE_FORMAT(data_bon, '%Y-%m') = ?", [$perioada]);
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
}