<?php

namespace Fenshenx\PhpConfluxSdk;

use Fenshenx\PhpConfluxSdk\Providers\IProvider;
use Fenshenx\PhpConfluxSdk\Providers\ProviderFactory;
use Fenshenx\PhpConfluxSdk\Wallet\Wallet;
use Psr\Log\LoggerInterface;

class Conflux
{
    protected IProvider $provider;

    protected Cfx $cfx;

    protected Wallet $wallet;

    public function __construct(
        private string $url,
        private int $networkId,
        private int $timeout = 30 * 1000,
        protected ?LoggerInterface $logger = null
    )
    {
        $this->provider = ProviderFactory::getProvider($this->url, [
            "timeout" => $this->timeout,
            "logger" => $this->logger
        ]);

        $this->cfx = new Cfx($this);
        $this->wallet = new Wallet($this->networkId);
    }

    public function getProvider(): IProvider
    {
        return $this->provider;
    }

    public function getCfx()
    {
        return $this->cfx;
    }

    public function getContract()
    {
        //TODO: getContract
    }

    public function getWallet()
    {
        return $this->wallet;
    }
}