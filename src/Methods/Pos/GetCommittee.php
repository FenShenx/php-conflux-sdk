<?php

namespace Fenshenx\PhpConfluxSdk\Methods\Pos;

use Fenshenx\PhpConfluxSdk\Formatters\BigNumberFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\HexFormatter;
use Fenshenx\PhpConfluxSdk\Methods\BaseMethod;

class GetCommittee extends BaseMethod
{
    protected string $methodName = 'pos_getCommittee';

    protected array $requestFormatters = [
        0 => HexFormatter::class
    ];

    protected array $responseFormatters = [
        'currentCommittee' => [
            'epochNumber' => BigNumberFormatter::class,
            'quorumVotingPower' => BigNumberFormatter::class,
            'totalVotingPower' => BigNumberFormatter::class,
        ]
    ];

    protected function validate($params)
    {
    }
}