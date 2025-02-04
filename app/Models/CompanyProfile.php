<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    protected $fillable = [
        'user_id',
        'nume_companie',
        'cui_cnp',
        'id_apia',
        'localitate',
        'judet',
        'nume_prenume',
        'functie'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}