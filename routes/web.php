<?php

use App\Http\Controllers\InscriptionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Inscription');
});


Route::post('/register', [InscriptionController::class, 'Ajouter'])->name('register');
