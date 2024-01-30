<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Clients\IndexController as ClientsIndex;
use App\Http\Controllers\Clients\StoreController as ClientsStore;
use App\Http\Controllers\Orders\IndexController as OrdersIndex;


Route::get('/', function() {
    echo config('app.name');
});

Route::middleware('service-auth')->prefix('clients')->as('clients:')->group( static function(): void {
    Route::get('/', ClientsIndex::class)->name('list');
    Route::post('/', ClientsStore::class,)->name('register');
    Route::put('{ulid}')->name('update');
    Route::delete('{ulid}')->name('delete');

    Route::prefix('{ulid}')->group( static function(): void {
        Route::get('orders', OrdersIndex::class)->name('orders:list');

    });
});