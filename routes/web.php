<?php

use App\Livewire\BonUpload;
use App\Models\RezultatOcr;
use App\Livewire\ListaBonuri;
use Illuminate\Support\Facades\Route;
use App\Livewire\SituatiiCentralizatoare;

Route::view('/', 'welcome');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', BonUpload::class)->name('dashboard');
    Route::get('/bonuri/{rezultat}/edit', function (RezultatOcr $rezultat) {
        return view('bonuri.edit', compact('rezultat'));
    })->name('bonuri.edit');
    Route::get('/situatie-centralizatoare', SituatiiCentralizatoare::class)
        ->name('situatie-centralizatoare');
    // Route::get('/bonuri', ListaBonuri::class)->name('bonuri.index');
    
Route::view('profile', 'profile')->name('profile');
});




require __DIR__.'/auth.php';
