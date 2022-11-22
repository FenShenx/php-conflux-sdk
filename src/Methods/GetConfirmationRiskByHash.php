<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\BigNumberFormatter;

class GetConfirmationRiskByHash extends BaseMethod
{
    protected string $methodName = 'cfx_getConfirmationRiskByHash';

    protected array $responseFormatters = [
        BigNumberFormatter::class
    ];

    protected function validate($params)
    {
    }
}