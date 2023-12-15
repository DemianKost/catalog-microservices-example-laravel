<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

final class AccessTokenService
{
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