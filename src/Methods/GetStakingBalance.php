<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\DripFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\EpochNumberFormatter;

class GetStakingBalance extends BaseMethod
{
    protected string $methodName = "cfx_getStakingBalance";

    protected array $requestFormatters = [
        1 => EpochNumberFormatter::class
    ];

    protected array $responseFormatters = [
        DripFormatter::class
    ];

    protected function validate($params)
    {

    }
}