<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\BigNumberFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\IFormatter;

class GasPrice extends BaseMethod
{
    protected string $methodName = "cfx_gasPrice";

    protected function getPayload()
    {
        return [];
    }

    protected function formatResponse($response)
    {
        return BigNumberFormatter::format($response);
    }

    protected function validate($params)
    {

    }
}