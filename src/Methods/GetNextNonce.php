<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\BigNumberFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\EpochNumberFormatter;

class GetNextNonce extends BaseMethod
{
    protected string $methodName = "cfx_getNextNonce";

    protected array $requestFormatters = [
        1 => EpochNumberFormatter::class
    ];

    protected array $responseFormatters = [
        BigNumberFormatter::class
    ];

    protected function validate($params)
    {

    }
}