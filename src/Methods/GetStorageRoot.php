<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\EpochNumberFormatter;

class GetStorageRoot extends BaseMethod
{
    protected string $methodName = "cfx_getStorageRoot";

    protected array $requestFormatters = [
        1 => EpochNumberFormatter::class
    ];

    protected function validate($params)
    {

    }
}