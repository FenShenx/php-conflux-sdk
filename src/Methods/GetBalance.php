<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\DripFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\EpochNumberFormatter;
use Fenshenx\PhpConfluxSdk\Utils\FormatUtil;

class GetBalance extends BaseMethod
{
    protected string $methodName = "cfx_getBalance";

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