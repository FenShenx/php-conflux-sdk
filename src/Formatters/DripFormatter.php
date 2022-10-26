<?php

namespace Fenshenx\PhpConfluxSdk\Formatters;

use Fenshenx\PhpConfluxSdk\Drip;
use Fenshenx\PhpConfluxSdk\Utils\FormatUtil;

class DripFormatter implements IFormatter
{

    public static function format($value)
    {
        $dripAmount = FormatUtil::toBigNumber($value);

        return new Drip($dripAmount);
    }
}