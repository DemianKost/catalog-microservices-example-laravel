<?php

declare(strict_types=1);

use App\Models\User;
use App\Http\Controllers\Auth\LoginController;

it('it validates the users input', function(): void {
    $this->postJson(
        uri: action(LoginController::class),
        data: []
    )->assertStatus(
        status: 422
    )->assertJsonValidationErrorFor(
        key: 'email'
    )->assertJsonValidationErrorFor(
        key: 'password'
    );
});

it('returns the correct status if credentials are incorrect', function(): void {
    $user = User::factory()->create();
    
    $this->postJson(
        uri: action(LoginController::class),
        data: [
            'email' => $user->getAttribute('email'),
            'password' => 'password'
        ]
    )->assertStatus(
        status: 200
    );
});

todo('it will store an access token in cache');

todo('it will return the access code in the response.');