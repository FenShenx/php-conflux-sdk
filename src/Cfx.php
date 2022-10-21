<?php

namespace Fenshenx\PhpConfluxSdk;

use Fenshenx\PhpConfluxSdk\Methods\Exceptions\UnknownMethodException;
use Fenshenx\PhpConfluxSdk\Methods\IMethod;
use Fenshenx\PhpConfluxSdk\Providers\IProvider;

/**
 * @method getClientVersion()
 */
class Cfx
{
    private array $methods = [];

    public function __construct(
        private Conflux $conflux
    )
    {

    }

    public function __call(string $name, array $arguments)
    {
        $method = "\Fenshenx\PhpConfluxSdk\Methods\\".ucfirst($name);

        if (array_key_exists($method, $this->methods)) {
            $methodObj = $this->methods[$method];
        } else {

            if (!class_exists($method))
                throw new UnknownMethodException("Unknown method ".$method);

            /**
             * @var IMethod
             */
            $methodObj = new $method();

            if (!($methodObj instanceof IMethod))
                throw new UnknownMethodException("Method ".$method." not instance of ".IMethod::class);

            $methodObj->setParams($arguments);
            $this->methods[$method] = $methodObj;
        }

        //send request
        return $this->conflux->getProvider()->send($methodObj->getMethodName(), $methodObj->getMethodPayload());
    }
}