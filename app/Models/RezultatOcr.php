<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RezultatOcr extends Model
{
    protected $table = 'rezultat_ocr';
    
    protected $fillable = [
        'bon_id',
        'furnizor',
        'numar_bon',
        'data_bon',
        'cantitate_facturata',
        'cantitate_utilizata',
        'raw_data',
        'verified_at'
    ];

    protected $casts = [
        'cantitate_facturata' => 'decimal:2',
        'cantitate_utilizata' => 'decimal:2',
        'data_bon' => 'date',
        'verified_at' => 'datetime',
        'raw_data' => 'array'
    ];

    public function bon()
    {
        return $this->belongsTo(Bon::class);
    }
}