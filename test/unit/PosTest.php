<?php

namespace Test\Unit;

use Fenshenx\PhpConfluxSdk\Conflux;
use Test\TestCase;

class PosTest extends TestCase
{
    public function testGetStatus()
    {
        $pos = $this->getPos();

        $res = $pos->getStatus();

        $this->assertArrayHasKey('epoch', $res);
        $this->assertArrayHasKey('latestCommitted', $res);
        $this->assertArrayHasKey('latestVoted', $res);
        $this->assertArrayHasKey('pivotDecision', $res);
        $this->assertArrayHasKey('height', $res['pivotDecision']);
        $this->assertArrayHasKey('blockHash', $res['pivotDecision']);
    }

    public function testGetAccount()
    {
        $pos = $this->getPos();

        $res = $pos->getAccount('0x88df016429689c079f3b2f6ad39fa052532c56795b733da78a91ebe6a713944b');

        $this->assertArrayHasKey('address', $res);
        $this->assertArrayHasKey('blockNumber', $res);
        $this->assertArrayHasKey('status', $res);
    }

    private function getPos()
    {
        $conflux = $this->getConflux();
        $pos = $conflux->getPos();

        return $pos;
    }

    private function getConflux()
    {
        return new Conflux($this->testHost, $this->networkId);
    }
}