<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bon extends Model
{
    use HasFactory;

    protected $table = 'bons'; 

    protected $fillable = [
        'imagine_path',
        'status'
    ];

    public function rezultatOcr()
    {
        return $this->hasOne(RezultatOcr::class);
    }
}