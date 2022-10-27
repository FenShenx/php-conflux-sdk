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

        return '0x' . $publicKey;
    }

    private static function initSecp256k1()
    {
        if (empty(self::$secp256k1))
            self::$secp256k1 = new EC("secp256k1");
    }
}