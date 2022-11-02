<?php

namespace Fenshenx\PhpConfluxSdk;

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