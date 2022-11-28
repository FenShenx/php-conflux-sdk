<?php

namespace Fenshenx\PhpConfluxSdk;

/**
 * @method mixed getStatus()
 */
class Pos extends BaseRpcNamespace
{
    private string $rpcNamespace = "\Fenshenx\PhpConfluxSdk\Methods\Pos\\";

    protected function getMethodNamespace(): string
    {
        return $this->rpcNamespace;
    }
}