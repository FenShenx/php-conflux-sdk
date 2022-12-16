<?php

namespace Fenshenx\PhpConfluxSdk;

use Fenshenx\PhpConfluxSdk\Contract\Contract;
use Fenshenx\PhpConfluxSdk\Providers\IProvider;
use Fenshenx\PhpConfluxSdk\Providers\ProviderFactory;
use Fenshenx\PhpConfluxSdk\Wallet\Wallet;
use phpseclib3\Math\BigInteger;
use Psr\Log\LoggerInterface;

class Conflux
{
    protected IProvider $provider;

    protected Cfx $cfx;

    protected TxPool $txPool;

    protected Wallet $wallet;

    protected Pos $pos;

    private Drip $defaultGasPrice;

    private Drip $defaultTransactionGas;

    public function __construct(
        private string $url,
        private int $networkId,
        private int $timeout = 30,
        protected ?LoggerInterface $logger = null,
        int|BigInteger $defaultGasPrice = null,
        private int $defaultGasRatio = 1,
        private float $defaultStorageRatio = 1.1,
        IProvider $ownProvider = null
    )
    {
        if (is_null($ownProvider))
            $this->provider = ProviderFactory::getProvider($this->url, [
                "timeout" => $this->timeout,
                "logger" => $this->logger
            ]);
        else
            $this->provider = $ownProvider;

        $this->cfx = new Cfx($this);
        $this->txPool = new TxPool($this);
        $this->pos = new Pos($this);
        $this->wallet = new Wallet($this->networkId);

        if (!is_null($defaultGasPrice))
            $this->defaultGasPrice = new Drip($defaultGasPrice);

        $this->defaultTransactionGas = new Drip(21000);
    }

    public function getProvider(): IProvider
    {
        return $this->provider;
    }

    public function getCfx(): Cfx
    {
        return $this->cfx;
    }

    public function getTxPool(): TxPool
    {
        return $this->txPool;
    }

    public function getPos(): Pos
    {
        return $this->pos;
    }

    public function getContract($abi, $address)
    {
        return new Contract($this, $address, $abi);
    }

    public function getWallet()
    {
        return $this->wallet;
    }

    public function getNetworkId()
    {
        return $this->networkId;
    }

    public function getDefaultGasPrice()
    {
        if (empty($this->defaultGasPrice))
            return null;

        return clone $this->defaultGasPrice;
    }

    public function getDefaultTransactionGasPrice()
    {
        return clone $this->defaultTransactionGas;
    }

    public function getDefaultGasRatio()
    {
        return $this->defaultGasRatio;
    }

    public function getDefaultStorageRatio()
    {
        return $this->defaultStorageRatio;
    }
}