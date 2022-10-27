<?php

namespace Test\Unit\Utils;

use Fenshenx\PhpConfluxSdk\Utils\SignUtil;
use Test\TestCase;

class SignUtilTest extends TestCase
{
    public function testGetRandomBytes()
    {
        $len = 32;
        $b = SignUtil::getRandomBytes($len);

        $this->assertSame($len, strlen($b));
    }

    public function testGetRandomPrivateKey()
    {
        $privateKey = SignUtil::getRandomPrivateKey();

        $this->assertIsString($privateKey);
    }

    public function testPrivateKey2PublicKey()
    {
        $privateKey = "2f15f3566d29d42e6b0c1250f5de2d3cecf254f0bdfbca9018eb8123627310e7";
        $publicKey = "0x04e25b322386732960241d8d5376e44abba6e7167af6b880e11c49681191c84156e1b5f3c12697aa5afc88f59c4251c507d14f6a88df6399e79fef179bcd78fba9";

        $res = SignUtil::privateKey2PublicKey($privateKey);

        $this->assertIsString($res);
        $this->assertSame($publicKey, $res);
    }
}