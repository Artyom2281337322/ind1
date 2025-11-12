<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Главная страница - доступна всем
Route::get('/', [TrackController::class, 'index'])->name('tracks.index');

// Маршруты Breeze
require __DIR__.'/auth.php';

// Защищенные маршруты - только для авторизованных
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Маршруты коллекций
    Route::get('/collections', [CollectionController::class, 'index'])->name('collections.index');
    Route::post('/collections', [CollectionController::class, 'store'])->name('collections.store');
    Route::get('/collections/{id}', [CollectionController::class, 'show'])->name('collections.show');
    Route::put('/collections/{id}', [CollectionController::class, 'update'])->name('collections.update');
    Route::delete('/collections/{id}', [CollectionController::class, 'destroy'])->name('collections.destroy');
    
    // Добавление/удаление треков из коллекций
    Route::post('/collections/{id}/add-track', [CollectionController::class, 'addTrack'])->name('collections.add-track');
    Route::delete('/collections/{collectionId}/remove-track/{trackId}', [CollectionController::class, 'removeTrack'])->name('collections.remove-track');

    Route::post('/tracks', [TrackController::class, 'store'])->name('tracks.store');
});