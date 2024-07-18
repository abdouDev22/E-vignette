<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vignette extends Model
{
    protected $table = 'vignettes';

    protected $fillable = [
        'date',
        'prix'
    ];

    protected $casts = [
        'date' => 'date',
        'prix' => 'integer'
    ];

    // You can add relationships here if needed, for example:
    public function achats()
    {
        return $this->hasMany(Achat::class, 'id_vignette');
    }
}

