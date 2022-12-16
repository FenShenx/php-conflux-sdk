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
     * @param array $options
     * @return string
     */
    public function sendTransaction(Account $account, array $options = [])
    {
        $encodedData = $this->contractMethod->encodeInputs($this->args);

        if (!is_array($options))
            $options = [];

        $options = array_merge($options, [
            'from' => $account->getConfluxAddress(),
            'to' => $this->contractAddress,
            'data' => $encodedData
        ]);

        return $this->conflux->getCfx()->sendTransaction($options);
    }

    public function estimateGasAndCollateral(Account $account, array $options = [], EpochNumber|String|int|null $epochNumber = null)
    {
        $encodedData = $this->contractMethod->encodeInputs($this->args);

        if (!is_array($options))
            $options = [];

        $options = array_merge($options, [
            'from' => $account->getConfluxAddress(),
            'to' => $this->contractAddress,
            'data' => $encodedData
        ]);

        $params = [$options];

        if (!empty($epochNumber))
            $params[] = $epochNumber;

        return $this->conflux->getCfx()->estimateGasAndCollateral(...$params);
    }
}