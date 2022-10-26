<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\EpochNumberFormatter;

class GetBlockByEpochNumber extends BaseMethod
{
    protected string $methodName = "cfx_getBlockByEpochNumber";

    protected array $requestFormatters = [
        EpochNumberFormatter::class
    ];

    protected function validate($params)
    {

    }
}