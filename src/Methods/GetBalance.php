<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\DripFormatter;
use Fenshenx\PhpConfluxSdk\Utils\FormatUtil;

class GetBalance extends BaseMethod
{
    protected string $methodName = "cfx_getBalance";

    protected array $responseFormatters = [
        DripFormatter::class
    ];

    protected function getPayload()
    {
        $payload = parent::getPayload();

        if (!empty($epochNumberVal = $this->getEpochNumberParamValue($payload)))
            $payload[1] = $epochNumberVal;

        return $payload;
    }

    protected function validate($params)
    {
        if (!empty($epochNumberVal = $this->getEpochNumberParamValue($params)))
            FormatUtil::validateEpochNumber($epochNumberVal);
    }

    private function getEpochNumberParamValue($params)
    {
        if (isset($params[1]) && !empty($params[1]) && $params[1] instanceof \Fenshenx\PhpConfluxSdk\Enums\EpochNumber)
            return $params[1]->value;

        return null;
    }
}