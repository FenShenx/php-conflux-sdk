<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\EpochNumberFormatter;

class GetCode extends BaseMethod
{
    protected string $methodName = "cfx_getCode";

    protected array $requestFormatters = [
        1 => EpochNumberFormatter::class
    ];

    protected function validate($params)
    {
        // TODO: Implement validate() method.
    }
}