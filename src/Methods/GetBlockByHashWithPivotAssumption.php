<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\HexFormatter;

class GetBlockByHashWithPivotAssumption extends BaseMethod
{
    protected string $methodName = "cfx_getBlockByHashWithPivotAssumption";

    protected array $requestFormatters = [
        2 => HexFormatter::class
    ];

    protected function validate($params)
    {

    }
}