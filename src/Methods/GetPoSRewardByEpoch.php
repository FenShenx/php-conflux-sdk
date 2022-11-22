<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\EpochNumberFormatter;

class GetPoSRewardByEpoch extends BaseMethod
{
    protected string $methodName = 'cfx_getPoSRewardByEpoch';

    protected array $requestFormatters = [
        EpochNumberFormatter::class
    ];

    protected function validate($params)
    {
    }
}