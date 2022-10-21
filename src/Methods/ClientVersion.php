<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Providers\IProvider;

class ClientVersion extends BaseMethod
{
    protected string $methodName = "cfx_clientVersion";

    protected function getPayload()
    {
        return [];
    }

    protected function validate($params)
    {

    }
}