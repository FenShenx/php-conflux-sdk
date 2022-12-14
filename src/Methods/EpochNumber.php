<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\BigNumberFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\EpochNumberFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\HexFormatter;
use Fenshenx\PhpConfluxSdk\Methods\Exceptions\InvalidParamException;
use Fenshenx\PhpConfluxSdk\Utils\FormatUtil;

class EpochNumber extends BaseMethod
{
    protected string $methodName = "cfx_epochNumber";

    protected array $requestFormatters = [
        EpochNumberFormatter::class
    ];

    protected array $responseFormatters = [
        BigNumberFormatter::class
    ];

    protected function validate($params)
    {

    }
}