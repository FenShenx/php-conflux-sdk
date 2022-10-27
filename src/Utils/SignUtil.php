<?php

namespace Fenshenx\PhpConfluxSdk\Utils;

use kornrunner\Keccak;

class SignUtil
{
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
}