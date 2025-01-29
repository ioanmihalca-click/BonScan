<?php

use App\Livewire\BonUpload;
use App\Models\RezultatOcr;
use App\Livewire\ListaBonuri;
use Illuminate\Support\Facades\Route;
use App\Livewire\SituatiiCentralizatoare;

Route::get('/', BonUpload::class)->name('dashboard');

Route::get('/bonuri/{rezultat}/edit', function (RezultatOcr $rezultat) {
    return view('bonuri.edit', compact('rezultat'));
})->name('bonuri.edit');

Route::get('/situatie-centralizatoare', SituatiiCentralizatoare::class)->name('situatie-centralizatoare');
Route::get('/bonuri', ListaBonuri::class)->name('bonuri.index');
