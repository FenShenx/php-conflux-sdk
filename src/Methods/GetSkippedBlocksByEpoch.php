<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\EpochNumberFormatter;

class GetSkippedBlocksByEpoch extends BaseMethod
{
    protected string $methodName = 'cfx_getSkippedBlocksByEpoch';

    protected array $requestFormatters = [
        EpochNumberFormatter::class
    ];

    protected function validate($params)
    {
    }
}