<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\EpochNumberFormatter;

class GetAdmin extends BaseMethod
{
    protected string $methodName = "cfx_getAdmin";

    protected array $requestFormatters = [
        1 => EpochNumberFormatter::class
    ];

    protected function validate($params)
    {

    }
}