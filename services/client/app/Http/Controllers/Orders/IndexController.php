<?php

declare(strict_types=1);

namespace App\Http\Controllers\Orders;

use Illuminate\Http\Request;

final class IndexController
{
    /**
     * @param Request $request
     * @param string $ulid
     */
    public function __invoke(Request $request, string $ulid)
    {
        // does this client exist?

        // get all orders for this client

        // return the resonse
    }
}
