<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

class GetTransactionByHash extends BaseMethod
{
    protected string $methodName = 'cfx_getTransactionByHash';

    protected function validate($params)
    {
    }
}