<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\DripFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\EpochNumberFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\HexFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\StringHexFormatter;

class EstimateGasAndCollateral extends BaseMethod
{
    protected string $methodName = 'cfx_estimateGasAndCollateral';

    protected array $requestFormatters = [
        0 => [
            'gas' => HexFormatter::class,
            'gasPrice' => HexFormatter::class,
            'value' => HexFormatter::class,
            'nonce' => HexFormatter::class,
        ],
        1 => EpochNumberFormatter::class
    ];

    protected array $responseFormatters = [
        'gasLimit' => DripFormatter::class,
        'gasUsed' => DripFormatter::class,
        'storageCollateralized' => DripFormatter::class
    ];

    protected function validate($params)
    {

    }
}