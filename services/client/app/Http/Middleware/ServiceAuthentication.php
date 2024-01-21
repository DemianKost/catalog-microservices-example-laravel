<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

final class ServiceAuthentication
{
    /**
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ( ! $request->hasHeader('Authorization') ) {
            throw new AuthenticationException(
                message: 'Please include your Access Token in the request',
                guards: ['api']
            );
        }

        $token = Str::of(
            string: $request->header('Authorization'),
        )->after(
            search: 'Bearer ',
        )->toString();

        dd( Redis::get($token) );

        if ( ! $identity = Redis::get('laravel_database_' . $token) ) {
            throw new AuthenticationException(
                message: 'Invalid Access Token',
                guards: ['api']
            );
        }

        return $next($request);
    }
}
