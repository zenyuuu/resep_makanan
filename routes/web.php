<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResepController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Simple health-check endpoint for automated checks (returns JSON)
Route::get('/health', function () {
    $checks = [];
    $ok = true;

    // Database connection
    try {
        \DB::connection()->getPdo();
        $checks['database'] = 'ok';
    } catch (\Exception $e) {
        $ok = false;
        $checks['database'] = $e->getMessage();
    }

    // migrations/table
    try {
        $has = \Illuminate\Support\Facades\Schema::hasTable('reseps');
        $checks['migrations.reseps_table'] = $has ? 'ok' : 'missing';
        if (! $has) {
            $ok = false;
        }
    } catch (\Exception $e) {
        $ok = false;
        $checks['migrations'] = $e->getMessage();
    }

    // storage link & writable
    $checks['storage_link'] = is_link(public_path('storage')) || file_exists(public_path('storage')) ? 'ok' : 'missing';
    $checks['storage_writable'] = is_writable(storage_path('app/public')) ? 'ok' : 'not_writable';

    // storage disk access
    try {
        \Illuminate\Support\Facades\Storage::disk('public')->exists('') ;
        $checks['storage_disk'] = 'ok';
    } catch (\Exception $e) {
        $ok = false;
        $checks['storage_disk'] = $e->getMessage();
    }

    return response()->json(['status' => $ok ? 'ok' : 'fail', 'checks' => $checks], $ok ? 200 : 503);
})->name('health');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Resource routes for reseps (CRUD)
// public: index, show
Route::resource('reseps', ResepController::class)->only(['index', 'show']);

// protected: create, store, edit, update, destroy
// For local development allow unauthenticated create/edit/delete; otherwise require auth
if (app()->environment('local')) {
    Route::resource('reseps', ResepController::class)->except(['index', 'show']);
} else {
    Route::middleware('auth')->group(function () {
        Route::resource('reseps', ResepController::class)->except(['index', 'show']);
    });
}

// Home route
Route::get('/home', function () {
    return view('home');
})->name('home');

require __DIR__.'/auth.php';
