<?php

namespace Fenshenx\PhpConfluxSdk\Contract;

use Fenshenx\PhpConfluxSdk\Conflux;
use Fenshenx\PhpConfluxSdk\Enums\EpochNumber;
use Fenshenx\PhpConfluxSdk\Transaction;
use Fenshenx\PhpConfluxSdk\Wallet\Account;

class MethodTransaction
{
    public function __construct(
        private Conflux $conflux,
        private ContractMethod $contractMethod,
        private array $args
    )
    {

    }

    public function send()
    {

    }

    public function sendTransaction(Account $account)
    {

    }

    public function estimateGasAndCollateral(Account $account, EpochNumber|String|int|null $epochNumber = null)
    {

    }
}