<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

class GetClientVersion implements IMethod
{
    private string $methodName = "cfx_clientVersion";

    public function setParams($params)
    {

    }

    public function getMethodName(): string
    {
        return $this->methodName;
    }

    public function getMethodPayload(): array
    {
        return [];
    }
}