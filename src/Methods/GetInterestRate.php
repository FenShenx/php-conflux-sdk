<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\BigNumberFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\EpochNumberFormatter;

class GetInterestRate extends BaseMethod
{
    protected string $methodName = 'cfx_getInterestRate';

    protected array $requestFormatters = [
        EpochNumberFormatter::class,
    ];

    protected array $responseFormatters = [
        BigNumberFormatter::class
    ];

    protected function validate($params)
    {
    }
}