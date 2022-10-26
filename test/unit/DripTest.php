<?php

namespace Test\Unit;

use Fenshenx\PhpConfluxSdk\Drip;
use phpseclib3\Math\BigInteger;
use Test\TestCase;

class DripTest extends TestCase
{
    public function testFromCfx()
    {
        $cfx = 10;
        $drip = Drip::fromCFX($cfx);
        $this->assertSame($drip->getDrip(), "10000000000000000000");
        $this->assertSame((int)$drip->toCFX(), $cfx);
    }

    public function testFromGDrip()
    {
        $gdrip = 10;
        $drip = Drip::fromGdrip($gdrip);
        $this->assertSame($drip->getDrip(), "10000000000");
        $this->assertSame((int)$drip->toGdrip(), $gdrip);
    }

    public function testDrip()
    {
        $amount1 = 10;
        $drip1 = new Drip($amount1);
        $this->assertSame((int)$drip1->getDrip(), $amount1);

        $amount2 = "100000000000000000000";
        $drip2 = new Drip($amount2);
        $this->assertSame($drip2->getDrip(), $amount2);

        $amount3 = new BigInteger("100000000000000000000");
        $drip3 = new Drip($amount3);
        $this->assertSame($drip3->getDrip(), $amount3->toString());

        $amount4 = new BigInteger("0x1158e45ff8e9ed6e1", 16);
        $drip4 = new Drip($amount4);
        $this->assertSame("19.999999959110702817", $drip4->toCFX());
    }
}