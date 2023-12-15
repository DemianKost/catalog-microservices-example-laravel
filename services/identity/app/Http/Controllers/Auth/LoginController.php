<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Exceptions\AuthenticationException;
use App\Http\Request\Auth\LoginRequest;
use App\Services\AccessTokenService;
use Illuminate\Contracts\Auth\Factory;
use Treblle\Tools\Http\Responses\MessageResponse;

final class LoginController
{
    public function __construct(
        private readonly Factory $auth,
        private AccessTokenService $service
    ) {}

    public function __invoke(LoginRequest $request)
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
