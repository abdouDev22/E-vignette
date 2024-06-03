<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BaseContent;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/',[BaseContent::class,'index'])->name('base');
Route::get('/vigetteObetnu',[BaseContent::class,'vigetteObetnu'])->name('vigetteObetnu');
Route::get('/achatVignette',[BaseContent::class,'achatVignette'])->name('achatVignette');
Route::get('/service',[BaseContent::class,'service'])->name('service');
Route::get('/profile',[BaseContent::class,'profile'])->name('profile');
Route::get('/vignette',[BaseContent::class,'vignette'])->name('vignette');

Route::resource('posts', PostController::class);
