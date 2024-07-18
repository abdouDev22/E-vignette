<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModePaiement extends Model
{
    protected $table = 'mode_paiement';

    protected $fillable = [
        'mode'
    ];

    // You can add relationships here if needed, for example:
    public function achats()
    {
        return $this->hasMany(Achat::class, 'id_mode_paiement');
    }
}

