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

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
})->name('health');

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

Route::get('/reseps', [ResepController::class, 'index'])->name('reseps.index');
Route::get('/reseps/{resep}', [ResepController::class, 'show'])->name('reseps.show');

// Protected routes - require auth
Route::middleware('auth')->group(function () {
    Route::get('/reseps/create', [ResepController::class, 'create'])->name('reseps.create');
    Route::post('/reseps', [ResepController::class, 'store'])->name('reseps.store');
    Route::get('/reseps/{resep}/edit', [ResepController::class, 'edit'])->name('reseps.edit');
    Route::patch('/reseps/{resep}', [ResepController::class, 'update'])->name('reseps.update');
    Route::put('/reseps/{resep}', [ResepController::class, 'update'])->name('reseps.update');
    Route::delete('/reseps/{resep}', [ResepController::class, 'destroy'])->name('reseps.destroy');
});

Route::post('/reseps/{resep}/favorite', [App\Http\Controllers\ResepController::class, 'favorite'])->name('reseps.favorite')->middleware('auth');
Route::get('/favorites', [ResepController::class, 'favorites'])->name('reseps.favorites')->middleware('auth');

require __DIR__.'/auth.php';
