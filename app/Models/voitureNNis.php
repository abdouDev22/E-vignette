<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class voitureNNis extends Model
{
    protected $table = 'voiturennis'; // Assurez-vous que cela correspond au nom de votre table
    
    // Ajoutez les champs que votre table contient
    protected $fillable = [
        'nom_proprio',
        'matricule',
        'marque',
        'type',
        'NNIclient',
        'chevaux',
    ];
}
