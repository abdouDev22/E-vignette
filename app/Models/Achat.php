<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Achat extends Model
{
    protected $table = 'achat';
    protected $fillable = [
        'Date',
        'prix',
        'id_mode_paiement',
        'id_voiture',
        'id_vignette',
        'id_code_q_r',
        'id_client'
    ];

    protected $casts = [
        'Date' => 'date',
        'prix' => 'integer',
        'id_mode_paiement' => 'integer',
        'id_voiture' => 'integer',
        'id_vignette' => 'integer',
        'id_code_q_r' => 'integer',
        'id_client' => 'integer'
    ];

    public function modePaiement()
    {
        return $this->belongsTo(ModePaiement::class, 'id_mode_paiement');
    }

    public function voiture()
    {
        return $this->belongsTo(Voiture::class, 'id_voiture');
    }

    public function vignette()
    {
        return $this->belongsTo(Vignette::class, 'id_vignette');
    }

    public function codeQR()
    {
        return $this->belongsTo(CodeQR::class, 'id_code_q_r');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'id_client');
    }
}

