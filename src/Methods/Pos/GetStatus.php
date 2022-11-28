<?php
namespace Fenshenx\PhpConfluxSdk\Methods\Pos;

use Fenshenx\PhpConfluxSdk\Formatters\BigNumberFormatter;
use Fenshenx\PhpConfluxSdk\Methods\BaseMethod;

class GetStatus extends BaseMethod
{
    protected string $methodName = 'pos_getStatus';

    protected array $responseFormatters = [
        'epoch' => BigNumberFormatter::class,
        'latestCommitted' => BigNumberFormatter::class,
        'latestVoted' => BigNumberFormatter::class,
        'pivotDecision' => [
            'height' => BigNumberFormatter::class
        ]
    ];

    protected function validate($params)
    {
    }
}