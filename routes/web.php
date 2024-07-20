<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BaseContent;
use App\Http\Controllers\CodeQRController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});



Route::get('/dashboard', [BaseContent::class, 'welcome'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Partie développée avec Breeze-Laravel
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Partie développée sans librairie
    Route::get('/vigetteObetnu/{id}', [BaseContent::class, 'vigetteObetnu'])->name('vigetteObetnu');
    Route::get('/achatVignette', [BaseContent::class, 'achatVignette'])->name('achatVignette');
    Route::get('/welcome', [BaseContent::class, 'welcome'])->name('welcome');
    Route::get('/service/{id}/{id_vignette}', [BaseContent::class, 'service'])->name('service');
    Route::get('/vignette/{id}', [BaseContent::class, 'vignette'])->name('vignette');
    Route::get('/codeqr/{id}/{id_vignette}/{id_mode}', [BaseContent::class, 'codeqr'])->name('codeqr');
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

  
    Route::get('/complete-registration', [RegisteredUserController::class, 'completeRegistration'])->name('complete-registration');
