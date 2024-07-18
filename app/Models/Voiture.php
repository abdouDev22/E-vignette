<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voiture extends Model
{
    protected $fillable = [
        'matricule',
        'marque',
        'type',
        'chevaux',
        'id_client'
    ];

    protected $casts = [
        'chevaux' => 'integer',
        'id_client' => 'integer'
    ];

    // You can add relationships here, for example:
    public function client()
    {
        return $this->belongsTo(User::class, 'id_client');
    }
}

