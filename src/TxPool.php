<?php

namespace Fenshenx\PhpConfluxSdk;

use Fenshenx\PhpConfluxSdk\Methods\Exceptions\UnknownMethodException;
use Fenshenx\PhpConfluxSdk\Methods\IMethod;
use phpseclib3\Math\BigInteger;

/**
 * @method BigInteger nextNonce($accountAddress)
 */
class TxPool extends BaseRpcNamespace
{
    private string $rpcNamespace = "\Fenshenx\PhpConfluxSdk\Methods\TxPool\\";

    protected function getMethodNamespace(): string
    {
        return $this->rpcNamespace;
    }
}