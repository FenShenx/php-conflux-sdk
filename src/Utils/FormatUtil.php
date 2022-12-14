<?php

namespace Fenshenx\PhpConfluxSdk\Utils;

use Fenshenx\PhpConfluxSdk\Drip;
use Fenshenx\PhpConfluxSdk\Enums\EpochNumber;
use phpseclib3\Math\BigInteger;

class FormatUtil
{
    private function __construct() {}

    public static function toBigNumber($number)
    {
        if (is_numeric($number))
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
            if ($hex == '')
                $hex = '0x0';
        } else {
            throw new \Exception('The value to toHex function is not support.');
        }
        if ($isPrefix) {
            return self::zeroPrefix($hex);
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

    public static function zeroPrefix($value)
    {
        if (self::isZeroPrefixed($value))
            return $value;

        return '0x'.$value;
    }

    public static function getEpochNumbers()
    {
        return EpochNumber::getCases();
    }

    public static function validateEpochNumber($epochNumber)
    {
        if (!in_array($epochNumber, self::getEpochNumbers()))
            throw new \Exception("Undefined epoch number ".$epochNumber);
    }
}