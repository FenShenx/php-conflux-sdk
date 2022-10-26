<?php

namespace Test\Unit;

use Fenshenx\PhpConfluxSdk\Conflux;
use Fenshenx\PhpConfluxSdk\Drip;
use Fenshenx\PhpConfluxSdk\Enums\EpochNumber;
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

        $res = $cfx->gasPrice();

        $this->assertInstanceOf(Drip::class, $res);
    }

    public function testEpochNumber()
    {
        $cfx = $this->getCfx();

        $tag1 = 97011356;
        $res1 = $cfx->epochNumber($tag1);
        $this->assertSame($tag1, (int)$res1->toString());

        foreach (EpochNumber::cases() as $tag) {

            $res = $cfx->epochNumber($tag);
            $this->assertInstanceOf(BigInteger::class, $res);
        }
    }

    public function testGetBalance()
    {
        $cfx = $this->getCfx();
        $address = "cfxtest:aatmav6mw5tps6h61jp5wb0xwdk9f649gew3m3a04t";

        $drip = $cfx->getBalance($address);
        $this->assertInstanceOf(Drip::class, $drip);

        $drip2 = $cfx->getBalance($address, EpochNumber::LatestConfirmed);
        $this->assertInstanceOf(Drip::class, $drip2);
    }

    public function testGetAdmin()
    {
        $cfx = $this->getCfx();
        $contractAddress = "cfxtest:acgdtuumgpwxpdmptxmmjdmcn64cbdx1yugj81phc4";
        $adminAddress = "cfxtest:aatz19y0y2r1db8hnryn2jh2msxb3zpjtpbxwwjp86";

        $res = $cfx->getAdmin($contractAddress);

        $this->assertSame($res, $adminAddress);
    }

    private function getCfx()
    {
        $conflux = new Conflux($this->testHost, $this->networkId);
        $cfx = $conflux->getCfx();

        return $cfx;
    }
}