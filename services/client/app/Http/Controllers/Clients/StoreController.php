<?php

declare(strict_types=1);

namespace App\Http\Controllers\Clients;

use App\Commands\Clients\CreateNewClient;
use App\Commands\Companies\FirstOrCreate;
use App\Exceptions\WriteException;
use App\Http\Requests\Clients\StoreRequest;
use App\Http\Resources\ClientResource;
use Illuminate\Contracts\Support\Responsable;
use Throwable;
use Treblle\Tools\Http\Enums\Status;
use Treblle\Tools\Http\Responses\ModelResponse;

final readonly class StoreController
{
    public function __construct(
        private readonly CreateNewClient $command,
        private readonly FirstOrCreate $createCompany,
    ) {}

    /**
     * @param StoreRequest $request
     * @return Responsable
     * @throws WriteException|Throwable
     */
    public function __invoke(StoreRequest $request): Responsable
    {
        $payload = $request->payload();
        
        // Create company
        try {
            $company = $this->createCompany->handle(
                name: $payload->name,
                email: $payload->email,
            );
        } catch ( Throwable $exception ) {
            throw new WriteException(
                message: $exception->getMessage(),
                code: (int) $exception->getCode(),
                previous: $exception
            );
        }

        $payload = $payload->company(
            company: $company->getKey(),
        );

        // Create client
        try {
            $client = $this->command->handle(
                payload: $payload,
            );
        } catch ( Throwable $exception ) {
            throw new WriteException(
                message: $exception->getMessage(),
                code: (int) $exception->getCode(),
                previous: $exception
            );
        }

        return new ModelResponse(
            data: new ClientResource(
                resource: $client,
            ),
            status: Status::CREATED,
        );
    }
}
