<?php

namespace Fenshenx\PhpConfluxSdk\Wallet;

class Wallet
{
    /**
     * [confluxAddress => Account]
     * @var Account[]
     */
    private $accounts = [];

    public function __construct(
        private int $networkId
    )
    {

    }

    public function getNetworkId()
    {
        return $this->networkId;
    }

    public function has($address): bool
    {
        return isset($this->accounts[$address]);
    }

    public function delete($address): void
    {
        if ($this->has($address))
            unset($this->accounts[$address]);
    }

    public function clear(): void
    {
        $this->accounts = [];
    }

    public function get($address): Account|null
    {
        if ($this->has($address))
            return $this->accounts[$address];

        return null;
    }

    public function addPrivateKey($privateKey): Account
    {
        $account = new Account($privateKey, $this->networkId);

        if ($this->has($account->getConfluxAddress()))
            return $this->get($account->getConfluxAddress());

        $this->accounts[$account->getConfluxAddress()] = $account;

        return $account;
    }

    public function addRandom(): Account
    {
        $account = Account::random($this->networkId);

        $this->accounts[$account->getConfluxAddress()] = $account;

        return $account;
    }
}