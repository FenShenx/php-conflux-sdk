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
}