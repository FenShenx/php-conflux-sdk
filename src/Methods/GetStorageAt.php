<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\EpochNumberFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\HexFormatter;

class GetStorageAt extends BaseMethod
{
    protected string $methodName = "cfx_getStorageAt";

    protected array $requestFormatters = [
        1 => HexFormatter::class,
        2 => EpochNumberFormatter::class
    ];

    protected function validate($params)
    {

    }
}