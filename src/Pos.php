<?php

namespace Fenshenx\PhpConfluxSdk;

class Pos extends BaseRpcNamespace
{
    private string $rpcNamespace = "\Fenshenx\PhpConfluxSdk\Methods\Pos\\";

    protected function getMethodNamespace(): string
    {
        return $this->rpcNamespace;
    }
}