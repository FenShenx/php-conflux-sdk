<?php

namespace Fenshenx\PhpConfluxSdk;

use Fenshenx\PhpConfluxSdk\Enums\EpochNumber;
use Fenshenx\PhpConfluxSdk\Methods\Exceptions\UnknownMethodException;
use Fenshenx\PhpConfluxSdk\Methods\IMethod;
use Fenshenx\PhpConfluxSdk\Providers\IProvider;
use phpseclib3\Math\BigInteger;

/**
 * @method string clientVersion()
 * @method Drip gasPrice()
 * @method BigInteger epochNumber(EpochNumber|String|int $epochNumber)
 * @method Drip getBalance($address, EpochNumber|String|int|null $epochNumber = null)
 * @method String getAdmin($contractAddress, EpochNumber|String|int|null $epochNumber = null)
 * @method array getSponsorInfo($contractAddress, EpochNumber|String|int|null $epochNumber = null)
 * @method Drip getStakingBalance($address, EpochNumber|String|int|null $epochNumber = null)
 * @method array getDepositList($address, EpochNumber|String|int|null $epochNumber = null)
 * @method array getVoteList($address, EpochNumber|String|int|null $epochNumber = null)
 * @method Drip getCollateralForStorage($address, EpochNumber|String|int|null $epochNumber = null)
 * @method string getCode($contractAddress, EpochNumber|String|int|null $epochNumber = null)
 * @method string getStorageAt($contractAddress, $position, EpochNumber|String|int|null $epochNumber = null)
 * @method array getStorageRoot($contractAddress, EpochNumber|String|int|null $epochNumber = null)
 * @method array getBlockByHash($blockHash, boolean $includeTxs)
 * @method array getBlockByHashWithPivotAssumption($blockHash, $pivotHash, $epochNumber)
 * @method array getBlockByEpochNumber(EpochNumber|String|int $epochNumber, boolean $includeTxs)
 * @method array getBlockByBlockNumber($blockNumber, boolean $includeTxs)
 */
class Cfx
{
    public function __construct(
        private Conflux $conflux
    )
    {

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
}