<?php

namespace Fenshenx\PhpConfluxSdk;

use Fenshenx\PhpConfluxSdk\Methods\Exceptions\UnknownMethodException;
use Fenshenx\PhpConfluxSdk\Methods\IMethod;

abstract class BaseRpcNamespace
{
    public function __construct(
        protected Conflux $conflux
    )
    {

    }

    abstract protected function getMethodNamespace(): string;

    public function __call(string $name, array $arguments)
    {
        $method = $this->getMethodNamespace().ucfirst($name);

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