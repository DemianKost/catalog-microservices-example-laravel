<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Clients\IndexController as ClientsIndex;
use App\Http\Controllers\Clients\StoreController as ClientsStore;
use App\Http\Controllers\Orders\IndexController as OrdersIndex;


Route::get('/', function() {
    echo config('app.name');
});

Route::middleware('service-auth')->prefix('clients')->as('clients:')->group( static function(): void {
    // 
});