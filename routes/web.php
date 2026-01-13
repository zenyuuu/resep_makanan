<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResepController;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use App\Models\Resep;

Route::get('/', function () : View {
    $latestRecipes = Resep::with('user')->latest()->take(6)->get();
    return view('welcome', compact('latestRecipes'));
})->name('home');

Route::get('/home', function () : View {
    $latestRecipes = Resep::with('user')->latest()->take(6)->get();
    return view('home', compact('latestRecipes'));
})->middleware(['auth', 'verified']);

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
Route::get('/favorites', [ResepController::class, 'favorites'])->name('reseps.favorites')->middleware('auth');

require __DIR__.'/auth.php';
