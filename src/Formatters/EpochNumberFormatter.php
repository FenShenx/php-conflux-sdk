<?php

namespace Fenshenx\PhpConfluxSdk\Formatters;

use Fenshenx\PhpConfluxSdk\Enums\EpochNumber;
use Fenshenx\PhpConfluxSdk\Utils\FormatUtil;

class EpochNumberFormatter implements IFormatter
{

    public static function format($value)
    {
        if ($value instanceof EpochNumber)
            return $value->value;

        return FormatUtil::numberToHex($value, true);
    }
}