<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\BigNumberFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\EpochNumberFormatter;

class GetSupplyInfo extends BaseMethod
{
    protected string $methodName = 'cfx_getSupplyInfo';

    protected array $requestFormatters = [
        EpochNumberFormatter::class
    ];

    protected array $responseFormatters = [
        'totalIssued' => BigNumberFormatter::class,
        'totalCollateral' => BigNumberFormatter::class,
        'totalStaking' => BigNumberFormatter::class,
        'totalCirculating' => BigNumberFormatter::class,
        'totalEspaceTokens' => BigNumberFormatter::class,
    ];

    protected function validate($params)
    {
    }
}