<?php

namespace Fenshenx\PhpConfluxSdk\Formatters;

use Fenshenx\PhpConfluxSdk\Utils\FormatUtil;

class BigNumberFormatter implements IFormatter
{

    public static function format($value)
    {
        return FormatUtil::toBigNumber($value);
    }
}