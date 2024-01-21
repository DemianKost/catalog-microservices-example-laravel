<?php

declare(strict_types=1);

use App\Http\Controllers\Clients\IndexController;
use Illuminate\Auth\AuthenticationException;

it('will throw an exception if not authenticated', function(): void {
    $this->getJson(
        uri: action(IndexController::class),
    );
})->throws(AuthenticationException::class);