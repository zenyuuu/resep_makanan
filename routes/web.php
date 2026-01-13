<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResepController;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

Route::get('/', function () : View {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('reseps', App\Http\Controllers\ResepController::class);
Route::post('/reseps/{resep}/favorite', [App\Http\Controllers\ResepController::class, 'favorite'])->name('reseps.favorite')->middleware('auth');
Route::get('/reseps', [ResepController::class, 'index'])->name('reseps.index');

require __DIR__.'/auth.php';
