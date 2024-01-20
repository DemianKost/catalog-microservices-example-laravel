<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\RegisterController;
use App\Models\User;
use Treblle\Tools\Http\Enums\Status;

it('it validates the users input', function(): void {
    $this->postJson(
        uri: action(RegisterController::class),
        data: [] 
    )->assertStatus(
        status: Status::UNPROCESSABLE_CONTENT->value
    )->assertJsonValidationErrorFor(
        key: 'name',
    )->assertJsonValidationErrorFor(
        key: 'email',
    )->assertJsonValidationErrorFor(
        key: 'password',
    );
});

it('creates the new user record', function(): void {
    expect(
        User::query()->count(),
    )->toEqual(0);

    $this->postJson(
        uri: action(RegisterController::class),
        data: [
            'name' => 'Testing',
            'email' => 'test@example.com',
            'password' => 'password'
        ]
    )->assertStatus(
        status: Status::CREATED->value
    );

    expect(
        User::query()->count(),
    )->toEqual(1);
});

it('it will store an access token in cache', function(): void {
    $response = $this->postJson(
        uri: action(RegisterController::class),
        data: [
            'name' => 'Testing',
            'email' => 'test@example.com',
            'password' => 'password'
        ]
    );

    expect(
        Cache::get($response->json('message'))
    )->toBeArray()->toHaveKeys(['id', 'role']);
});

todo('it will return the access code in the response.');