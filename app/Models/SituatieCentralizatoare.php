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
        // Validăm formatul perioadei
        if (!preg_match('/^\d{4}-T[1-3]$/', $perioada)) {
            throw new \InvalidArgumentException('Vă rugăm să selectați o perioadă validă din lista disponibilă (de exemplu: 2024 - Trimestrul 1)');
        }

        $parts = explode('-T', $perioada);
        $year = $parts[0];
        $trimester = $parts[1];

        // Creăm situația
        $situatie = self::create([
            'perioada' => $perioada,
            'status' => 'draft',
            'generated_at' => now()
        ]);

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
            default:
                throw new \InvalidArgumentException('Trimestrul trebuie să fie între 1 și 3');
        }

        // Găsim toate bonurile din trimestrul respectiv
        $bonuri = Bon::whereHas('rezultatOcr', function ($query) use ($year, $startMonth, $endMonth) {
            $query->whereYear('data_bon', $year)
                ->whereMonth('data_bon', '>=', $startMonth)
                ->whereMonth('data_bon', '<=', $endMonth);
        })->get();

        // Atașăm bonurile la situație doar dacă există
        if ($bonuri->isNotEmpty()) {
            $situatie->bonuri()->attach($bonuri->pluck('id'));
        }

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

}
