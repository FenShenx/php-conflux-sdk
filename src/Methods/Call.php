<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\EpochNumberFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\HexFormatter;

class Call extends BaseMethod
{
    protected string $methodName = 'cfx_call';

    protected array $requestFormatters = [
        0 => [
            'gas' => HexFormatter::class,
            'gasPrice' => HexFormatter::class,
            'nonce' => HexFormatter::class,
            'value' => HexFormatter::class,
        ],
        1 => EpochNumberFormatter::class
    ];

    protected function validate($params)
    {

    }
}