<?php

use App\Livewire\BonUpload;
use App\Models\RezultatOcr;
use Illuminate\Support\Facades\Route;

Route::get('/', BonUpload::class);

Route::get('/bonuri/{rezultat}/edit', function (RezultatOcr $rezultat) {
    return view('bonuri.edit', compact('rezultat'));
})->name('bonuri.edit');