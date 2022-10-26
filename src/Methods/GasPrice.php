<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\BigNumberFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\DripFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\IFormatter;

class GasPrice extends BaseMethod
{
    protected string $methodName = "cfx_gasPrice";

    protected array $responseFormatters = [
        DripFormatter::class
    ];

    protected function validate($params)
    {

    }
}