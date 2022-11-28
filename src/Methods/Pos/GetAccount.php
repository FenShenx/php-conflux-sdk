<?php

namespace Fenshenx\PhpConfluxSdk\Methods\Pos;

use Fenshenx\PhpConfluxSdk\Formatters\BigNumberFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\HexFormatter;
use Fenshenx\PhpConfluxSdk\Methods\BaseMethod;

class GetAccount extends BaseMethod
{
    protected string $methodName = 'pos_getAccount';

    protected array $requestFormatters = [
        1 => HexFormatter::class
    ];

    protected array $responseFormatters = [
        'blockNumber' => BigNumberFormatter::class,
        'status' => [
            'availableVotes' => BigNumberFormatter::class,
            'forfeited' => BigNumberFormatter::class,
            'forceRetired' => BigNumberFormatter::class,
            'locked' => BigNumberFormatter::class,
            'unlocked' => BigNumberFormatter::class
        ]
    ];

    protected function validate($params)
    {
    }
}