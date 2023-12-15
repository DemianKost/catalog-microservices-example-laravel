<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Auth\Authenticatable;

final class AccessTokenService
{
    /**
     * @param User<Authenticatable> $user
     * @return string
     */
    public function create(User $user): string
    {
        $token = Str::random(40);

        Cache::put(
            key: $token,
            value: [
                'id' => $user->getKey(),
                'role' => $user->getAttribute('role')
            ],
            ttl: now()->addHours(5)
        );

        return $token;
    }
}