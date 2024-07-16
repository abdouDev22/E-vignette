<?php

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
    // partie develloper avec breeze-laravel
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // partie develloper sans librairi
    Route::get('/vigetteObetnu/{id}',[BaseContent::class,'vigetteObetnu'])->name('vigetteObetnu');
    Route::get('/achatVignette',[BaseContent::class,'achatVignette'])->name('achatVignette');
    Route::get('/welcome',[BaseContent::class,'welcome'])->name('welcome');
    Route::get('/service/{id}/{id_vignette}',[BaseContent::class,'service'])->name('service');
    Route::get('/vignette/{id}',[BaseContent::class,'vignette'])->name('vignette');
    Route::get('/codeqr/{id}/{id_vignette}/{id_mode}',[BaseContent::class,'codeqr'])->name('codeqr');
    Route::post('/page_achat/{id}/{id_vignette}/{id_mode}', [BaseContent::class, 'page_achat'])->name('page_achat');
    Route::post('/generate-qr', [CodeQRController::class, 'generate']);
});
require __DIR__.'/auth.php';
