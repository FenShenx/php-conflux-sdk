<?php

namespace Fenshenx\PhpConfluxSdk;

use Fenshenx\PhpConfluxSdk\Methods\Exceptions\UnknownMethodException;
use Fenshenx\PhpConfluxSdk\Methods\IMethod;
use Fenshenx\PhpConfluxSdk\Providers\IProvider;
use phpseclib3\Math\BigInteger;

/**
 * @method string clientVersion()
 * @method BigInteger gasPrice()
 * @method BigInteger epochNumber($tag)
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