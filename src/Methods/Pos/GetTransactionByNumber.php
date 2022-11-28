<?php

namespace Fenshenx\PhpConfluxSdk\Methods\Pos;

use Fenshenx\PhpConfluxSdk\Formatters\BigNumberFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\HexFormatter;
use Fenshenx\PhpConfluxSdk\Methods\BaseMethod;

class GetTransactionByNumber extends BaseMethod
{
    protected string $methodName = 'pos_getTransactionByNumber';

    protected array $requestFormatters = [
        0 => HexFormatter::class
    ];

    protected array $responseFormatters = [
        'number' => BigNumberFormatter::class,
        'blockNumber' => BigNumberFormatter::class,
    ];

    protected function validate($params)
    {
    }
}