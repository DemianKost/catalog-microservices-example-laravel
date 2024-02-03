<?php

use App\Http\Controllers\Products\IndexController;
use Illuminate\Support\Facades\Route;


Route::get('/', function() {
    echo config('app.name');
});

Route::middleware('service-auth')->prefix('products')->as('products:')->group( static function(): void {
    Route::get('/', IndexController::class)->name('index');
});