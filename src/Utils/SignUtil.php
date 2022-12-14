<?php

namespace Fenshenx\PhpConfluxSdk\Utils;

use Elliptic\EC;
use kornrunner\Keccak;

class SignUtil
{
    private static EC $secp256k1;

    private function __construct() {}

    public static function getRandomBytes($size)
    {
        return random_bytes($size);
    }

    public static function getRandomPrivateKey()
    {
        $inner = Keccak::hash(self::getRandomBytes(64), 256);
        $middle = self::getRandomBytes(32).$inner.self::getRandomBytes(32);

        return Keccak::hash($middle, 256);
    }

    public static function privateKey2PublicKey($privateKey)
    {
        $privateKey = FormatUtil::stripZero($privateKey);

        if (strlen($privateKey) !== 64)
            throw new \Exception('Invalid private key length.');

        self::initSecp256k1();

        $privateKey = self::$secp256k1->keyFromPrivate($privateKey, 'hex');
        $publicKey = $privateKey->getPublic(false, 'hex');

        return FormatUtil::zeroPrefix(substr($publicKey, 2));
    }

    public static function publicKey2Address($publicKey)
    {
        $publicKey = FormatUtil::stripZero($publicKey);

        $publicKeyBin = hex2bin($publicKey);

        if (strlen($publicKeyBin) === 65)
            $publicKeyBin = substr($publicKeyBin, 1);

        if (strlen($publicKeyBin) !== 64)
            throw new \Exception("Invalid public key");

        $buffer = substr(hex2bin(Keccak::hash($publicKeyBin, 256)), -20);

        $buffer[0] = hex2bin(dechex((hexdec(bin2hex($buffer[0])) & 0x0f) | 0x10));

        return FormatUtil::zeroPrefix(bin2hex($buffer));
    }

    public static function publicKey2ConfluxAddress($publicKey, $networkId)
    {
        $publicKey = FormatUtil::stripZero($publicKey);

        $address = FormatUtil::stripZero(self::publicKey2Address($publicKey));
        $buffer = hex2bin($address);

        if (strlen($buffer) !== 20)
            throw new \Exception("not match hex40");

        return self::address2ConfluxAddress($address, $networkId);
    }

    public static function privateKey2ConfluxAddress($privateKey, $networkId)
    {
        return self::publicKey2ConfluxAddress(self::privateKey2PublicKey($privateKey), $networkId);
    }

    public static function confluxAddress2Address($confluxAddress)
    {
        if (!is_string($confluxAddress) || ($confluxAddress !== strtoupper($confluxAddress) && $confluxAddress != strtolower($confluxAddress)))
            throw new \Exception("Mixed-case address ".$confluxAddress);

        return EncodeUtil::decodeCfxAddress($confluxAddress, true)["hex_address"];
    }

    public static function hasNetworkPrefix($address)
    {
        if (!is_string($address))
            return false;

        $parts = explode(":", strtolower($address));

        if (count($parts) !== 2 && count($parts) !== 3)
            return false;

        return str_starts_with($parts[0], EncodeUtil::PREFIX_CFX);
    }

    public static function address2ConfluxAddress($address, $networkId)
    {
        return EncodeUtil::encodeCfxAddress($address, $networkId);
    }

    private static function initSecp256k1()
    {
        if (empty(self::$secp256k1))
            self::$secp256k1 = new EC("secp256k1");
    }
}