<?php

namespace Test\Unit;

use Fenshenx\PhpConfluxSdk\Conflux;
use Fenshenx\PhpConfluxSdk\Enums\BlockTag;
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

    public function testGetCommittee()
    {
        $pos = $this->getPos();

        $res = $pos->getCommittee();

        $this->assertArrayHasKey('currentCommittee', $res);
        $this->assertArrayHasKey('epochNumber', $res['currentCommittee']);
        $this->assertArrayHasKey('quorumVotingPower', $res['currentCommittee']);
        $this->assertArrayHasKey('totalVotingPower', $res['currentCommittee']);
        $this->assertArrayHasKey('nodes', $res['currentCommittee']);
    }

    public function testGetBlockByHash()
    {
        $pos = $this->getPos();
        $param = '0x18a6b9c237f025e934a1633bae0cc084f81a457e3be75300447e857c3bc89d82';

        $res = $pos->getBlockByHash($param);

        $this->assertArrayHasKey('hash', $res);
        $this->assertArrayHasKey('height', $res);
        $this->assertArrayHasKey('epoch', $res);
        $this->assertArrayHasKey('round', $res);
        $this->assertArrayHasKey('lastTxNumber', $res);
        $this->assertArrayHasKey('parentHash', $res);
        $this->assertArrayHasKey('timestamp', $res);
        $this->assertArrayHasKey('pivotDecision', $res);
        $this->assertSame($param, $res['hash']);
    }

    public function testGetBlockByNumber()
    {
        $pos = $this->getPos();

        $res = $pos->getBlockByNumber(BlockTag::LatestCommitted);

        $this->assertArrayHasKey('hash', $res);
        $this->assertArrayHasKey('height', $res);
        $this->assertArrayHasKey('epoch', $res);
        $this->assertArrayHasKey('round', $res);
        $this->assertArrayHasKey('lastTxNumber', $res);
        $this->assertArrayHasKey('parentHash', $res);
        $this->assertArrayHasKey('timestamp', $res);
        $this->assertArrayHasKey('pivotDecision', $res);
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