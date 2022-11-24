<?php

namespace Fenshenx\PhpConfluxSdk\Methods\TxPool;

use Fenshenx\PhpConfluxSdk\Formatters\BigNumberFormatter;
use Fenshenx\PhpConfluxSdk\Methods\BaseMethod;

class NextNonce extends BaseMethod
{
    protected string $methodName = 'txpool_nextNonce';

    protected array $responseFormatters = [
        BigNumberFormatter::class,
    ];

    protected function validate($params)
    {
    }
}