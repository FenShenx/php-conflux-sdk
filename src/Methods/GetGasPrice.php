<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\BigNumberFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\IFormatter;

class GetGasPrice extends BaseMethod
{
    protected string $methodName = "cfx_gasPrice";

    protected array $responseFormatters = [
        BigNumberFormatter::class
    ];

    protected function getPayload()
    {
        return [];
    }

    protected function formatResponse($response)
    {
        /**
         * @var IFormatter
         */
        $formatter = new $this->responseFormatters[0]();

        return $formatter->format($response);
    }

    protected function validate($params)
    {

    }
}