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

    /**
     * send call
     * @return array|mixed|\phpseclib3\Math\BigInteger|void
     * @throws \Exception
     */
    public function send()
    {
        $encodedData = $this->contractMethod->encodeInputs($this->args);

        $res = $this->conflux->getCfx()->call([
            'to' => $this->contractAddress,
            'data' => $encodedData
        ]);

        return $this->contractMethod->decodeOutputs($res);
    }

    /**
     * send transaction call
     * @param Account $account
     * @return void
     */
    public function sendTransaction(Account $account)
    {
        $encodedData = $this->contractMethod->encodeInputs($this->args);
        $options = [
            'from' => $account->getConfluxAddress(),
            'to' => $this->contractAddress,
            'data' => $encodedData
        ];

        return $this->conflux->getCfx()->sendTransaction($options);
    }

    public function estimateGasAndCollateral(Account $account, EpochNumber|String|int|null $epochNumber = null)
    {

    }
}