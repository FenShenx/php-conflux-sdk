<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Providers\IProvider;

class GetClientVersion extends BaseMethod
{
    protected string $methodName = "cfx_clientVersion";

    protected function getPayload()
    {
        return [];
    }

    protected function formatResponse($response)
    {
        return $response;
    }

    protected function validate($params)
    {

    }
}