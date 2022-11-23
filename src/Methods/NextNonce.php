<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\BigNumberFormatter;

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