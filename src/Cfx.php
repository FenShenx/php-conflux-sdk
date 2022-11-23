<?php

namespace Fenshenx\PhpConfluxSdk;

use Fenshenx\PhpConfluxSdk\Enums\EpochNumber;
use Fenshenx\PhpConfluxSdk\Methods\Exceptions\UnknownMethodException;
use Fenshenx\PhpConfluxSdk\Methods\IMethod;
use Fenshenx\PhpConfluxSdk\Providers\IProvider;
use Fenshenx\PhpConfluxSdk\Utils\EncodeUtil;
use Fenshenx\PhpConfluxSdk\Utils\FormatUtil;
use Fenshenx\PhpConfluxSdk\Utils\SignUtil;
use Fenshenx\PhpConfluxSdk\Wallet\Account;
use phpseclib3\Math\BigInteger;

/**
 * @method string clientVersion()
 * @method Drip gasPrice()
 * @method BigInteger epochNumber(EpochNumber|string|int $epochNumber=null)
 * @method Drip getBalance($address, EpochNumber|string|int|null $epochNumber = null)
 * @method string getAdmin($contractAddress, EpochNumber|string|int|null $epochNumber = null)
 * @method array getSponsorInfo($contractAddress, EpochNumber|string|int|null $epochNumber = null)
 * @method Drip getStakingBalance($address, EpochNumber|string|int|null $epochNumber = null)
 * @method array getDepositList($address, EpochNumber|string|int|null $epochNumber = null)
 * @method array getVoteList($address, EpochNumber|string|int|null $epochNumber = null)
 * @method Drip getCollateralForStorage($address, EpochNumber|string|int|null $epochNumber = null)
 * @method string getCode($contractAddress, EpochNumber|string|int|null $epochNumber = null)
 * @method string getStorageAt($contractAddress, $position, EpochNumber|string|int|null $epochNumber = null)
 * @method array getStorageRoot($contractAddress, EpochNumber|string|int|null $epochNumber = null)
 * @method array getBlockByHash($blockHash, boolean $includeTxs)
 * @method array getBlockByHashWithPivotAssumption($blockHash, $pivotHash, $epochNumber)
 * @method array getBlockByEpochNumber(EpochNumber|string|int $epochNumber, boolean $includeTxs)
 * @method array getBlockByBlockNumber($blockNumber, boolean $includeTxs)
 * @method string getBestBlockHash()
 * @method BigInteger getNextNonce($address, EpochNumber|string|int|null $epochNumber = null)
 * @method array getStatus()
 * @method array estimateGasAndCollateral(array $options, EpochNumber|string|int|null $epochNumber = null)
 * @method mixed call(array $callRequest, EpochNumber|string|int|null $epochNumber = null)
 * @method array getLogs(array $filter)
 * @method array getTransactionByHash(string $hash)
 * @method array getAccountPendingInfo(string $accountAddress)
 * @method array getAccountPendingTransactions(string $accountAddress, string|null $maybeStartNonce=null, string|null $maybeLimit=null)
 * @method array checkBalanceAgainstTransaction(string $accountAddress, string $contractAddress, Drip|int|BigInteger $gasLimit, Drip|int|BigInteger $gasPrice, int|BigInteger $storageLimit)
 * @method array getBlocksByEpoch(EpochNumber|string|int $epochNumber)
 * @method array getSkippedBlocksByEpoch(EpochNumber|string|int $epochNumber)
 * @method mixed getTransactionReceipt(string $transHash)
 * @method mixed getAccount(string $accountAddress, EpochNumber|string|int|null $epochNumber = null)
 * @method BigInteger getInterestRate(EpochNumber|string|int $epochNumber)
 * @method BigInteger getAccumulateInterestRate(EpochNumber|string|int $epochNumber)
 * @method mixed getPoSEconomics(EpochNumber|string|int $epochNumber)
 * @method BigInteger getConfirmationRiskByHash(string $blockHash)
 * @method array getBlockRewardInfo(EpochNumber|string|int $epochNumber)
 * @method mixed getSupplyInfo(EpochNumber|string|int|null $epochNumber = null)
 * @method mixed getPoSRewardByEpoch(EpochNumber|string|int $epochNumber)
 */
class Cfx
{
    private int $transactionStorageLimit = 0;

    public function __construct(
        private readonly Conflux $conflux
    )
    {

    }

    public function sendTransaction($options)
    {
        if ($this->conflux->getWallet()->has($options['from'])) {

            $signedTransactionData = $this->populateAndSignTransaction($options);
            return $this->__call('sendRawTransaction', [FormatUtil::zeroPrefix($signedTransactionData)]);
        }

        throw new \Exception('wallet does not have '.$options['from'].' account');
    }

    public function __call(string $name, array $arguments)
    {
        $method = "\Fenshenx\PhpConfluxSdk\Methods\\".ucfirst($name);

        if (!class_exists($method))
            throw new UnknownMethodException("Unknown method ".$method);

        /**
         * @var IMethod
         */
        $methodObj = new $method($this->conflux->getProvider());

        if (!($methodObj instanceof IMethod))
            throw new UnknownMethodException("Method ".$method." not instance of ".IMethod::class);

        $methodObj->setParams($arguments);

        //send request
        return $methodObj->send();
    }

    private function populateAndSignTransaction($options)
    {
        $options = $this->populateTransaction($options);
        $account = $this->conflux->getWallet()->get($options['from']);

        return $account->signTransaction($options)->hash();
    }

    private function populateTransaction($options)
    {
        $defaultGasPrice = $this->conflux->getDefaultGasPrice();
        $defaultTransactionGasPrice = $this->conflux->getDefaultTransactionGasPrice();
        $defaultGasRatio = $this->conflux->getDefaultGasRatio();
        $defaultStorageRatio = $this->conflux->getDefaultStorageRatio();

        $fromAddress = $options['from'];

        if (empty($options['nonce'])) {

            $nonce = $this->__call("nextNonce", [$fromAddress]);

            if (empty($nonce))
                $nonce = $this->getNextNonce($fromAddress);

            if ($nonce->toHex() == '')
                $nonce = '0';
            else
                $nonce = $nonce->toHex();

            $options['nonce'] = FormatUtil::zeroPrefix($nonce);
        }

        if (empty($options['chainId']))
            $options['chainId'] = $this->conflux->getNetworkId();

        if (empty($options['chainId'])) {

            $status = $this->getStatus();
            $options['chainId'] = $status["chainId"];
        }

        if (empty($options['epochHeight']))
            $options['epochHeight'] = FormatUtil::zeroPrefix($this->epochNumber()->toHex());

        if (empty($options['gas']) || empty($options['storageLimit'])) {

            $isToUser = isset($options['to']) &&
                !empty($options['to']) &&
                EncodeUtil::decodeCfxAddress($options['to'])['type'] === EncodeUtil::TYPE_USER;

            if ($isToUser && empty($options['data'])) {
                $gas = $defaultTransactionGasPrice;
                $storageLimit = $this->transactionStorageLimit;
            } else {
                /**
                 * @var Drip $gasLimit
                 * @var Drip $gasUsed
                 * @var Drip $storageCollateralized
                 */
                list('gasLimit' => $gasLimit, 'gasUsed' => $gasUsed, 'storageCollateralized' => $storageCollateralized)
                    = $this->estimateGasAndCollateral($options);

                if (!empty($defaultGasRatio)) {

                    $gasBigint = $gasUsed->getDripBigint()->multiply(new BigInteger($defaultGasRatio));

                    $maxGas = new BigInteger(15000000);
                    if (((int)$gasBigint->subtract($maxGas)->toString()) > 0)
                        $gasBigint = $maxGas;

                    $gas = new Drip($gasBigint);
                } else {

                    $gas = $gasLimit;
                }
                $storageLimit = new Drip($storageCollateralized->getDripBigint()->multiply(new BigInteger($defaultStorageRatio)));
            }

            if (empty($options['gas']))
                $options['gas'] = $gas;

            if (empty($options['storageLimit']))
                $options['storageLimit'] = $storageLimit;
        }

        if (empty($options['gasPrice'])) {
            if (empty($defaultGasPrice)) {
                $options['gasPrice'] = $this->gasPrice();
            } else {
                $options['gasPrice'] = $defaultGasPrice;
            }
        }

        if (empty($options['value'])) {
            $options['value'] = new Drip(0);
        }

        return $options;
    }
}