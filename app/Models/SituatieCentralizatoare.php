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
        'status'
    ];
}