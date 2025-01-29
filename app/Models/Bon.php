<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bon extends Model
{
    protected $table = 'bonuri';
    
    protected $fillable = [
        'imagine_path',
        'status',
        'user_id'  
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rezultatOcr()
    {
        return $this->hasOne(RezultatOcr::class);
    }
}