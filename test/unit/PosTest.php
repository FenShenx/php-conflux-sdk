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