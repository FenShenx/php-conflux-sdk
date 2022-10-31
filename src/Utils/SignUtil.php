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

        return '0x' . substr($publicKey, 2);
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

        return bin2hex($buffer);
    }

    public static function publicKey2ConfluxAddress($publicKey, $networkId)
    {
        $publicKey = FormatUtil::stripZero($publicKey);

        $address = self::publicKey2Address($publicKey);
        $buffer = hex2bin($address);

        if (strlen($buffer) !== 20)
            throw new \Exception("not match hex40");

        return EncodeUtil::encodeCfxAddress($address, $networkId);
    }

    private static function initSecp256k1()
    {
        if (empty(self::$secp256k1))
            self::$secp256k1 = new EC("secp256k1");
    }
}