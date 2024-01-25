<?php

declare(strict_types=1);

namespace App\Http\Controllers\Clients;

use App\Commands\Clients\CreateNewClient;
use App\Exceptions\WriteException;
use App\Http\Requests\Clients\StoreRequest;
use Throwable;

final class StoreController
{
    public function __construct(
        private readonly CreateNewClient $command,
    ) {}

    /**
     * @param StoreRequest $request
     */
    public function __invoke(StoreRequest $request)
    {
        $payload = $request->payload();

        try {
            $client = $this->command->handle(
                payload: $payload,
            );
        } catch ( Throwable $exception ) {
            throw new WriteException(
                message: $exception->getMessage(),
                code: $exception->getCode(),
                previous: $exception
            );
        }
    }
}
