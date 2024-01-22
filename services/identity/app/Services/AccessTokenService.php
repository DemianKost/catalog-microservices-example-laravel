<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\Authenticatable;

final class AccessTokenService
{
    public function __construct(
        private readonly DatabaseManager $database
    ) {}

    /**
     * @param array{name:string,email:string,password:string} $data
     * @return User|Model
     */
    public function createUser(array $data): User|Model
    {
        return $this->database->transaction(
            callback: fn () => User::query()->create($data),
            attempts: 2
        );
    }

    /**
     * @param User<Authenticatable> $user
     * @return string
     */
    public function create(User $user): string
    {
        $token = Str::random(40);

        Redis::set(
            $token,
            json_encode(
                value: [
                    'id' => $user->getKey(),
                    'role' => $user->role
                ],
                flags: JSON_THROW_ON_ERROR,
            )
        );
        return $token;
    }
}