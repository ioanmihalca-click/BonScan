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
        'metadata',
        'generated_at',
        'user_id'
    ];

    protected $casts = [
        'metadata' => 'array',
        'generated_at' => 'datetime'
    ];

    // Relație multe-la-unu cu utilizatorul care a generat situația
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // Relație multe-la-multe cu bonurile
    public function bonuri()
    {
        return $this->belongsToMany(Bon::class, 'situatie_bon', 'situatie_id', 'bon_id')
            ->withTimestamps();
    }

    // Metodă pentru a genera situația pentru o anumită perioadă
    public static function generateForPeriod($perioada, $userId)
    {
        // Validăm formatul perioadei
        if (!preg_match('/^\d{4}-T[1-3]$/', $perioada)) {
            throw new \InvalidArgumentException('Vă rugăm să selectați o perioadă validă.');
        }
    
        $parts = explode('-T', $perioada);
        $year = $parts[0];
        $trimester = $parts[1];
    
        // Preluăm metadata de la ultima situație
        $lastSituatie = self::where('user_id', $userId)
            ->whereNotNull('metadata')
            ->latest()
            ->first();
    
        // Creăm situația cu user_id și metadata
        $situatie = self::create([
            'perioada' => $perioada,
            'generated_at' => now(),
            'user_id' => $userId,
            'metadata' => $lastSituatie ? $lastSituatie->metadata : null // Copiem metadata
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

        // Găsim toate bonurile utilizatorului din trimestrul respectiv
        $bonuri = Bon::where('user_id', $userId)
            ->whereHas('rezultatOcr', function ($query) use ($year, $startMonth, $endMonth) {
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
