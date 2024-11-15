<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BaseContent;
use App\Http\Controllers\CodeQRController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('page');
});

Route::get('/dashboard', [BaseContent::class, 'welcome'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/welcome', [BaseContent::class, 'welcome'])->name('welcome');
    Route::get('/vignetteObtenue/{voiture}', [BaseContent::class, 'vignetteObtenue'])->name('vignetteObtenue');
    Route::get('/achatVignette', [BaseContent::class, 'achatVignette'])->name('achatVignette');
    Route::get('/vignette/{voiture}', [BaseContent::class, 'vignette'])->name('vignette');
    Route::get('/service/{voiture}/{vignette}', [BaseContent::class, 'service'])->name('service');
    Route::get('/codeqr/{voiture}/{vignette}/{modePaiement}', [BaseContent::class, 'codeqr'])->name('codeqr');
    Route::post('/page_achat/{voiture}/{vignette}/{modePaiement}', [BaseContent::class, 'page_achat'])->name('page_achat');

    Route::post('/generate-qr', [CodeQRController::class, 'generate']);
});

require __DIR__.'/auth.php';


Route::get('/verify-email', function () {
    return view('auth.verify-email'); // Spécifiez le chemin correct
})->name('verify-email');


Route::get('/verify-code', [VerificationController::class, 'showForm'])->name('verify-code');
Route::post('/verify-code', [VerificationController::class, 'verifyCode']);
// Route pour renvoyer l'email de vérification
Route::post('/verification/send', [VerificationController::class, 'resendVerificationEmail'])
    ->name('verification.send');
