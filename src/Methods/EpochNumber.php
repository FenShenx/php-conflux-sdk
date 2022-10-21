<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\BigNumberFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\HexFormatter;
use Fenshenx\PhpConfluxSdk\Methods\Exceptions\InvalidParamException;

class EpochNumber extends BaseMethod
{
    protected string $methodName = "cfx_epochNumber";

    private $paramsTags = [
        'earliest', 'latest_checkpoint', 'latest_finalized', 'latest_confirmed', 'latest_state', 'latest_mined'
    ];

    protected function getPayload()
    {
        return [$this->params];
    }

    protected function formatRequest($payload)
    {
        if (!in_array($payload[0], $this->paramsTags))
            $payload[0] = HexFormatter::format($payload[0]);

        return $payload;
    }

    protected function formatResponse($response)
    {
        return BigNumberFormatter::format($response);
    }

    protected function validate($params)
    {
        if (empty($params))
            throw new InvalidParamException("params can not be empty");
    }
}