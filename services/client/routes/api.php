<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    echo config('app.name');
});

Route::middleware('service-auth')->prefix('clients')->as('clients:')->group( static function(): void {
    Route::get('/', App\Http\Controllers\Clients\IndexController::class)->name('list');
    Route::post('/', App\Http\Controllers\Clients\StoreController::class,)->name('register');
    Route::put('{ulid}')->name('update');
    Route::delete('{ulid}')->name('delete');

    Route::prefix('{ulid}')->group( static function(): void {
        Route::get('orders')->name('orders:list');

    });
});