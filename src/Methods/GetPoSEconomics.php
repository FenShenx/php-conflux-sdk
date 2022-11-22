<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\BigNumberFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\EpochNumberFormatter;

class GetPoSEconomics extends BaseMethod
{
    protected string $methodName = 'cfx_getPoSEconomics';

    protected array $requestFormatters = [
        EpochNumberFormatter::class
    ];

    protected array $responseFormatters = [
        'distributablePosInterest' => BigNumberFormatter::class,
        'lastDistributeBlock' => BigNumberFormatter::class,
        'totalPosStakingTokens' => BigNumberFormatter::class,
    ];

    protected function validate($params)
    {
    }
}