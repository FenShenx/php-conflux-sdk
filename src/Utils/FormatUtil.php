<?php

namespace Fenshenx\PhpConfluxSdk\Utils;

use phpseclib3\Math\BigInteger;

class FormatUtil
{
    public static function toBigNumber($number)
    {
        if (is_int($number))
            return new BigInteger($number);

        if (is_string($number) && self::isZeroPrefixed($number))
            return new BigInteger($number, 16);

        throw new \Exception($number.' not a Integer');
    }

    public static function numberToHex($value, $isPrefix=false)
    {
        if (is_numeric($value)) {
            // turn to hex number
            $bn = self::toBigNumber($value);
            $hex = $bn->toHex(true);
            $hex = preg_replace('/^0+(?!$)/', '', $hex);
        } elseif (is_string($value)) {
            $value = self::stripZero($value);
            $hex = implode('', unpack('H*', $value));
        } elseif ($value instanceof BigInteger) {
            $hex = $value->toHex(true);
            $hex = preg_replace('/^0+(?!$)/', '', $hex);
        } else {
            throw new \Exception('The value to toHex function is not support.');
        }
        if ($isPrefix) {
            return '0x' . $hex;
        }
        return $hex;
    }

    public static function stripZero($value)
    {
        if (self::isZeroPrefixed($value)) {
            $count = 1;
            return str_replace('0x', '', $value, $count);
        }
        return $value;
    }

    public static function isZeroPrefixed($value)
    {
        return str_starts_with(strtolower($value), '0x');
    }
}