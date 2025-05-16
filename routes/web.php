<?php

use App\Http\Controllers\CitadelController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/citadel', [CitadelController::class, 'index']);


Route::prefix('post')
    ->name('post.')
    ->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('index');
        Route::get('/array-test', [PostController::class, 'arrayTest'])->name('array_test');
        Route::get('/tab-direction', [PostController::class, 'tabDirection'])->name('tab_direction');
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::post('/store', [PostController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [PostController::class, 'update'])->name('update');
        Route::post('/{id}/destroy', [PostController::class, 'destroy'])->name('destroy');
    });
