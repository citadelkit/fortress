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
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::post('/store', [PostController::class, 'store'])->name('store');
        Route::get('/{post}/edit', [PostController::class, 'edit'])->name('edit');
        Route::post('/{post}/update', [PostController::class, 'update'])->name('update');
        Route::post('/{post}/destroy', [PostController::class, 'destroy'])->name('destroy');
    });
