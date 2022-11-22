<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\EpochNumberFormatter;

class GetBlocksByEpoch extends BaseMethod
{
    protected string $methodName = 'cfx_getBlocksByEpoch';

    protected array $requestFormatters = [
        EpochNumberFormatter::class
    ];

    protected function validate($params)
    {
    }
}