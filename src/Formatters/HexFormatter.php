<?php

namespace Fenshenx\PhpConfluxSdk\Formatters;

use Fenshenx\PhpConfluxSdk\Utils\FormatUtil;

class HexFormatter implements IFormatter
{

    public static function format($value)
    {
        return FormatUtil::numberToHex($value, true);
    }
}