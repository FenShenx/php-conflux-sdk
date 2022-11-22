<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\EpochNumberFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\HexFormatter;

class CheckBalanceAgainstTransaction extends BaseMethod
{
    protected string $methodName = 'cfx_checkBalanceAgainstTransaction';

    protected array $requestFormatters = [
        2 => HexFormatter::class,
        3 => HexFormatter::class,
        4 => HexFormatter::class,
        5 => EpochNumberFormatter::class
    ];

    protected function validate($params)
    {
    }
}