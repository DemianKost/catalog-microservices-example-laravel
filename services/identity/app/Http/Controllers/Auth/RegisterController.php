<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AccessTokenService;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Hash;
use Treblle\Tools\Http\Enums\Status;
use Treblle\Tools\Http\Responses\MessageResponse;

final class RegisterController
{
    public function __construct(
        private readonly AccessTokenService $service,
    ) {}
    
    /**
     * @param RegisterRequest $request
     * @return Responsable
     */
    public function __invoke(RegisterRequest $request): Responsable
    {
        $user = $this->service->createUser(
            data: [
                'name' => $request->string('name')->toString(),
                'email' => $request->string('email')->toString(),
                'password' => Hash::make(
                    value: $request->string('password')->toString()
                )
            ]
        );

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
