<?php

namespace Fenshenx\PhpConfluxSdk\Contract;

use Fenshenx\PhpConfluxSdk\Conflux;
use Fenshenx\PhpConfluxSdk\Enums\EpochNumber;
use Fenshenx\PhpConfluxSdk\Transaction;
use Fenshenx\PhpConfluxSdk\Wallet\Account;

class MethodTransaction
{
    private Account $signAccount;

    public function __construct(
        private Conflux $conflux,
        private ContractMethod $contractMethod,
        private string $contractAddress,
        private array $args
    )
    {

    }

    public function send()
    {
        //TODO: Sign data

        $encodedData = $this->contractMethod->encodeInputs($this->args);

        $res = $this->conflux->getCfx()->call([
            'to' => $this->contractAddress,
            'data' => $encodedData
        ]);

        return $this->contractMethod->decodeOutputs($res);
    }

    public function sendTransaction(Account $account)
    {
        $this->signAccount = $account;

        return $this;
    }

    public function estimateGasAndCollateral(Account $account, EpochNumber|String|int|null $epochNumber = null)
    {

    }
}