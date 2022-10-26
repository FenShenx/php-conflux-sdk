<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\DripFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\EpochNumberFormatter;

class GetSponsorInfo extends BaseMethod
{
    protected string $methodName = "cfx_getSponsorInfo";

    protected array $requestFormatters = [
        1 => EpochNumberFormatter::class
    ];

    protected array $responseFormatters = [
        "sponsorGasBound" => DripFormatter::class,
        "sponsorBalanceForGas" => DripFormatter::class,
        "sponsorBalanceForCollateral" => DripFormatter::class
    ];

    protected function validate($params)
    {

    }
}