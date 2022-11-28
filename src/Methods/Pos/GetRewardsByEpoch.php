<?php

namespace Fenshenx\PhpConfluxSdk\Methods\Pos;

use Fenshenx\PhpConfluxSdk\Formatters\BigNumberFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\HexFormatter;
use Fenshenx\PhpConfluxSdk\Methods\BaseMethod;

class GetRewardsByEpoch extends BaseMethod
{
    protected string $methodName = 'pos_getRewardsByEpoch';

    protected array $requestFormatters = [
        0 => HexFormatter::class
    ];

    protected function validate($params)
    {
    }
}