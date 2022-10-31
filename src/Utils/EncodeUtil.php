<?php

namespace Fenshenx\PhpConfluxSdk\Utils;

use phpseclib3\Math\BigInteger;

class EncodeUtil
{
    const TYPE_USER = "user";

    const TYPE_CONTRACT = "contract";

    const TYPE_BUILTIN = 'builtin';

    const TYPE_NULL = 'null';

    const TYPE_UNKNOWN = 'unknown';

    const PREFIX_CFX = "cfx";

    const PREFIX_CFXTEST = "cfxtest";

    const PREFIX_NET = "net";

    const NETID_MAIN = 1029;

    const NETID_TEST = 1;

    const VERSION_BYTE = 0;

    const ALPHABET = 'ABCDEFGHJKMNPRSTUVWXYZ0123456789';

    private function __construct()
    {
    }

    public static function getAddressType($hexAddress)
    {
        $hexAddress = FormatUtil::stripZero($hexAddress);

        $buffer = hex2bin($hexAddress);

        $type = hexdec(bin2hex($buffer[0])) & 0xf0;

        switch ($type) {
            case 0x10:
                return EncodeUtil::TYPE_USER;
            case 0x80:
                return EncodeUtil::TYPE_CONTRACT;
            case 0x00:
                throw new \Exception("builtin type TODO");
            //TODO:
            default:
                return EncodeUtil::TYPE_UNKNOWN;
        }
    }

    public static function encodeNetId($networkId)
    {
        switch ($networkId) {
            case EncodeUtil::NETID_MAIN:
                return EncodeUtil::PREFIX_CFX;
            case EncodeUtil::NETID_TEST:
                return EncodeUtil::PREFIX_CFXTEST;
            default:
                return EncodeUtil::PREFIX_NET . $networkId;
        }
    }

    public static function encodeCfxAddress($hexAddress, $networkId, $verbose = false)
    {
        $hexAddress = FormatUtil::stripZero($hexAddress);

        $addressType = self::getAddressType($hexAddress);
        $netName = self::encodeNetId($networkId);
        $netName5Bits = array_map(function ($byte) {
            $_byte = hexdec(bin2hex($byte)) & 31;
            return $_byte;
        }, str_split(strtoupper($netName)));

        $payload5Bits = self::convertBit(array_merge([0], array_map(function ($byte) {

            $_byte = hexdec(bin2hex($byte));
            return $_byte;

        }, str_split(hex2bin($hexAddress)))), 8, 5, true);

        $checksumBigInt = self::polyMod(array_merge($netName5Bits, [0], $payload5Bits, [0, 0, 0, 0, 0, 0, 0, 0]));
        $checksumBytes = $checksumBigInt->toBytes();
        $checksum5Bits = self::convertBit(array_map(function ($byte) {
            return hexdec(bin2hex($byte));
        }, str_split($checksumBytes)), 8, 5, true);

        $toBase32 = function ($i) {
            return EncodeUtil::ALPHABET[$i];
        };

        $payload = implode(array_map($toBase32, $payload5Bits));
        $checksum = implode(array_map($toBase32, $checksum5Bits));

        return $verbose
            ? strtoupper($netName.":TYPE.".$addressType.":".$payload.$checksum)
            : strtolower($netName.":".$payload.$checksum);
    }

    private static function convertBit($buffer, int $inBits, int $outBits, bool $pad) {

        $mask = (1 << $outBits) - 1;
        $array = [];
        $bits = 0;
        $value = 0;

        foreach ($buffer as $_byte) {

            $bits += $inBits;
            $value = $value << $inBits | $_byte;

            while ($bits >= $outBits) {
                $bits -= $outBits;
                $array[] = (self::uRightShift($value, $bits) & $mask);
            }
        }

        $value = $value << $outBits - $bits & $mask;

        if ($bits && $pad) {
            $array[] = $value;
        } elseif ($value && !$pad) {
            throw new \Exception("Excess padding");
        } elseif ($bits >= $inBits && !$pad) {
            throw new \Exception("Non-zero padding");
        }

        return $array;
    }

    private static function polyMod($data) : BigInteger {

        $c = new BigInteger(1);

        $xor1 = new BigInteger(0x98f2bc8e61);
        $xor2 = new BigInteger(0x79b76d99e2);
        $xor3 = new BigInteger(0xf33e5fb3c4);
        $xor4 = new BigInteger(0xae2eabe2a8);
        $xor5 = new BigInteger(0x1e4f43e470);

        foreach ($data as $item) {

            $c0 = hexdec($c->bitwise_rightShift(35)->toHex());
            $c = $c->bitwise_and(new BigInteger(0x07ffffffff))->bitwise_leftShift(5)->bitwise_xor(new BigInteger($item));

            if ($c0 & 0x01)
                $c = $c->bitwise_xor($xor1);

            if ($c0 & 0x02)
                $c = $c->bitwise_xor($xor2);

            if ($c0 & 0x04)
                $c = $c->bitwise_xor($xor3);

            if ($c0 & 0x08)
                $c = $c->bitwise_xor($xor4);

            if ($c0 & 0x10)
                $c = $c->bitwise_xor($xor5);
        }

        return $c->bitwise_xor(new BigInteger(1));
    }

    private static function uRightShift($v, $n)
    {
        return ($v & 0xFFFFFFFF) >> ($n & 0x1F);
    }
}