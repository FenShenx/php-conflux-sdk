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

        $res = $cfx->clientVersion();

        $this->assertIsString($res);
    }

    public function testGetGasPrice()
    {
        $cfx = $this->getCfx();

        /**
         * @var BigInteger
         */
        $res = $cfx->gasPrice();

        $this->assertInstanceOf(BigInteger::class, $res);
    }

    public function testEpochNumber()
    {
        $cfx = $this->getCfx();

        $tag1 = 97011356;
        $res1 = $cfx->epochNumber($tag1);
        $this->assertSame($tag1, (int)$res1->toString());

        $paramsTags = [
            'earliest', 'latest_checkpoint', 'latest_finalized', 'latest_confirmed', 'latest_state', 'latest_mined'
        ];

        foreach ($paramsTags as $tag) {

            $res = $cfx->epochNumber($tag);
            $this->assertInstanceOf(BigInteger::class, $res);
        }
    }

    private function getCfx()
    {
        $conflux = new Conflux($this->testHost, $this->networkId);
        $cfx = $conflux->getCfx();

        return $cfx;
    }
}