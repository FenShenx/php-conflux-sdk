<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

class GetAccountPendingTransactions extends BaseMethod
{
    protected string $methodName = 'cfx_getAccountPendingTransactions';

    protected function validate($params)
    {
    }
}