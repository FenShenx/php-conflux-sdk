<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\DripFormatter;
use Fenshenx\PhpConfluxSdk\Formatters\EpochNumberFormatter;

class GetVoteList extends BaseMethod
{
    protected string $methodName = "cfx_getVoteList";

    protected array $requestFormatters = [
        1 => EpochNumberFormatter::class
    ];

    protected array $responseFormatters = [
        'amount' => DripFormatter::class
    ];

    protected function validate($params)
    {

    }
}