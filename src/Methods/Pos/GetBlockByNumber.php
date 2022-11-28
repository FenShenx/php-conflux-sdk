<?php

namespace Fenshenx\PhpConfluxSdk\Methods\Pos;

use Fenshenx\PhpConfluxSdk\Formatters\BigNumberFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\BlockTagFormatter;
use Fenshenx\PhpConfluxSdk\Methods\BaseMethod;

class GetBlockByNumber extends BaseMethod
{
    protected string $methodName = 'pos_getBlockByNumber';

    protected array $requestFormatters = [
        0 => BlockTagFormatter::class
    ];

    protected array $responseFormatters = [
        'epoch' => BigNumberFormatter::class,
        'height' => BigNumberFormatter::class,
        'lastTxNumber' => BigNumberFormatter::class,
        'round' => BigNumberFormatter::class,
        'timestamp' => BigNumberFormatter::class,
        'pivotDecision' => [
            'height' => BigNumberFormatter::class
        ]
    ];

    protected function validate($params)
    {
    }
}