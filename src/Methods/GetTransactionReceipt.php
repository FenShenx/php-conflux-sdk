<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

class GetTransactionReceipt extends BaseMethod
{
    protected string $methodName = 'cfx_getTransactionReceipt';

    protected function validate($params)
    {
    }
}