<?php

namespace Test\Unit;

use Fenshenx\PhpConfluxSdk\Conflux;
use phpseclib3\Math\BigInteger;
use Test\TestCase;

class CfxTest extends TestCase
{
    public function testGetClientVersion()
    {
        $cfx = $this->getCfx();

        $res = $cfx->getClientVersion();

        $this->assertIsString($res);
    }

    public function testGetGasPrice()
    {
        $cfx = $this->getCfx();

        /**
         * @var BigInteger
         */
        $res = $cfx->getGasPrice();

        $this->assertInstanceOf(BigInteger::class, $res);
    }

    private function getCfx()
    {
        $conflux = new Conflux($this->testHost, $this->networkId);
        $cfx = $conflux->getCfx();

        return $cfx;
    }
}