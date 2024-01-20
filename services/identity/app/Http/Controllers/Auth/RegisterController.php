<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Exceptions\AuthenticationException;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AccessTokenService;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Hash;
use Treblle\Tools\Http\Enums\Status;
use Treblle\Tools\Http\Responses\MessageResponse;
use \Throwable;

final class RegisterController
{
    public function __construct(
        private readonly AccessTokenService $service,
    ) {}
    
    /**
     * @param RegisterRequest $request
     * @return Responsable
     * @throws \Throwable 
     */
    public function __invoke(RegisterRequest $request): Responsable
    {
        try {
            $user = $this->service->createUser(
                data: [
                    'name' => $request->string('name')->toString(),
                    'email' => $request->string('email')->toString(),
                    'password' => Hash::make(
                        value: $request->string('password')->toString()
                    )
                ]
            );
        } catch ( Throwable $exception ) {
            throw new AuthenticationException(
                message: 'Failed to create user account',
                code: Status::INTERNAL_SERVER_ERROR->value,
                previous: $exception
            );
        }

        return new MessageResponse(
            data: [
                'message' => $this->service->create(
                    user: $user
                )
            ],
            status: Status::CREATED,
        );
    }
}
