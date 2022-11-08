<?php

namespace Fenshenx\PhpConfluxSdk\Formatters;

use Fenshenx\PhpConfluxSdk\Drip;
use Fenshenx\PhpConfluxSdk\Utils\FormatUtil;

class HexFormatter implements IFormatter
{

    public static function format($value)
    {
        if ($value instanceof Drip) {

            $valueHex = FormatUtil::stripZero($value->getDripHex());

            // remove zero digits
            if (str_starts_with($valueHex, '0'))
                $valueHex = substr($valueHex, 1);

            return FormatUtil::zeroPrefix($valueHex);
        }

        return FormatUtil::numberToHex($value, true);
    }
}