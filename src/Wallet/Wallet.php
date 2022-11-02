<?php

namespace Fenshenx\PhpConfluxSdk\Wallet;

class Wallet
{
    public function __construct(
        private int $networkId
    )
    {

    }

    public function getNetworkId()
    {
        return $this->networkId;
    }
}