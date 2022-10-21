<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Providers\IProvider;

class GetClientVersion extends BaseMethod
{
    protected string $methodName = "cfx_clientVersion";

    public function setParams($params) {}

    protected function getPayload()
    {
        return [];
    }

    protected function formatResponse($response)
    {
        return $response;
    }
}