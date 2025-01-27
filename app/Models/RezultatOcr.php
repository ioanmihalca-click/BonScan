<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RezultatOcr extends Model
{
    use HasFactory;

    protected $table = 'rezultate_ocr';

    protected $fillable = [
        'bon_id',
        'furnizor',
        'numar_bon',
        'data_bon',
        'cantitate',
        'valoare',
        'raw_data'
    ];

    protected $casts = [
        'data_bon' => 'date',
        'raw_data' => 'array'
    ];

    public function bon()
    {
        return $this->belongsTo(Bon::class);
    }
}