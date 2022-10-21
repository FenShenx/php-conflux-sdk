<?php

namespace Fenshenx\PhpConfluxSdk\Utils;

use phpseclib3\Math\BigInteger;

class FormatUtil
{
    public static function toBigNumber($number)
    {
        if (is_int($number))
            return new BigInteger($number);

        if (is_string($number) && str_starts_with(strtolower($number), '0x'))
            return new BigInteger($number, 16);

        throw new \Exception($number.' not a Integer');
    }
}