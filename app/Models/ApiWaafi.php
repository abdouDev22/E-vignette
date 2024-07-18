<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiWaafi extends Model
{
    protected $table = 'api_waafi_1';

    protected $fillable = [
        'tel',
        'solde',
        'password',
        'failed_attempts',
        'last_failed_attempt'
    ];

    protected $casts = [
        'tel' => 'integer',
        'solde' => 'integer',
        'failed_attempts' => 'integer',
        'last_failed_attempt' => 'datetime'
    ];

    protected $hidden = [
        'password'
    ];
}

