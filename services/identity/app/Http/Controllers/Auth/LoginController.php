<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Exceptions\AuthenticationException;
use App\Http\Request\Auth\LoginRequest;
use Illuminate\Contracts\Auth\Factory;

final class LoginController
{
    public function __construct(
        private readonly Factory $auth
    ) {}

    public function __invoke(LoginRequest $request)
    {
        if ( $this->auth->guard()->attempt($request->only('email', 'password')) ) {
            throw new AuthenticationException(
                message: 'Invalid credentials for login'
            );
        }

        // check api access token
        

        // store api access token
        // return a response
    }
}
