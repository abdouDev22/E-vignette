<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CodeQR extends Model
{
    protected $table = 'codeQR';

    protected $fillable = ['contenu', 'boolean', 'fichier_path'];


    public $timestamps = true;
}
