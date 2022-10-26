<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\DripFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\EpochNumberFormatter;

class GetCollateralForStorage extends BaseMethod
{
    protected string $methodName = "cfx_getCollateralForStorage";

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