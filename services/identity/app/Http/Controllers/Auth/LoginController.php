<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Exceptions\AuthenticationException;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AccessTokenService;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Support\Responsable;
use Treblle\Tools\Http\Responses\MessageResponse;

final class LoginController
{
    public function __construct(
        private readonly Factory $auth,
        private AccessTokenService $service
    ) {}

    /**
     * @param LoginRequest $request
     * @return Responsable
     * @throws AuthenticationException
     */
    public function __invoke(LoginRequest $request): Responsable
    {
        if ( $this->auth->guard()->attempt($request->only('email', 'password')) ) {
            throw new AuthenticationException(
                message: 'Invalid credentials for login',
                code: 422
            );
        }
        
        $token = $this->service->create(
            user: $this->auth()->guard()->user()
        );

        return new MessageResponse(
            data: [
                'message' => $token
            ]
        );
    }
}
