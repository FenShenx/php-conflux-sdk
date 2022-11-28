<?php

namespace Fenshenx\PhpConfluxSdk;

use phpseclib3\Math\BigInteger;

/**
 * @method mixed getStatus()
 * @method mixed getAccount(string $accountAddress, int|BigInteger $blockNumber = null)
 * @method mixed getCommittee(int|BigInteger $blockNumber = null)
 * @method mixed getBlockByHash(string $blockHash)
 */
class Pos extends BaseRpcNamespace
{
    private string $rpcNamespace = "\Fenshenx\PhpConfluxSdk\Methods\Pos\\";

    protected function getMethodNamespace(): string
    {
        return $this->rpcNamespace;
    }
}