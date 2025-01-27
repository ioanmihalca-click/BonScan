<?php

use App\Livewire\BonUpload;
use App\Models\RezultatOcr;
use Illuminate\Support\Facades\Route;
use App\Livewire\SituatiiCentralizatoare;

Route::get('/', BonUpload::class);

Route::get('/bonuri/{rezultat}/edit', function (RezultatOcr $rezultat) {
    return view('bonuri.edit', compact('rezultat'));
})->name('bonuri.edit');

Route::get('/situatie-centralizatoare', SituatiiCentralizatoare::class);