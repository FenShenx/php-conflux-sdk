<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\HexFormatter;

class GetBlockByBlockNumber extends BaseMethod
{
    protected string $methodName = "cfx_getBlockByBlockNumber";

    protected array $requestFormatters = [
        HexFormatter::class
    ];

    protected function validate($params)
    {

    }
}