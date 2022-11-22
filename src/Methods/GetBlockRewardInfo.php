<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\BigNumberFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\EpochNumberFormatter;

class GetBlockRewardInfo extends BaseMethod
{
    protected string $methodName = 'cfx_getBlockRewardInfo';

    protected array $requestFormatters = [
        EpochNumberFormatter::class
    ];

    protected array $responseFormatters = [
        'totalReward' => BigNumberFormatter::class,
        'baseReward' => BigNumberFormatter::class,
        'txFee' => BigNumberFormatter::class
    ];

    protected function validate($params)
    {
    }
}