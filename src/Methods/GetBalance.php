<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\DripFormatter;

class GetBalance extends BaseMethod
{
    protected string $methodName = "cfx_getBalance";

    protected array $responseFormatters = [
        DripFormatter::class
    ];

    protected function validate($params)
    {

    }
}