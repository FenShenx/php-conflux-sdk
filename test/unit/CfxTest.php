<?php

namespace Test\Unit;

use Fenshenx\PhpConfluxSdk\Conflux;
use Test\TestCase;

class CfxTest extends TestCase
{
    public function testGetClientVersion()
    {
        $conflux = new Conflux($this->testHost, $this->networkId);
        $cfx = $conflux->getCfx();

        $res = $cfx->getClientVersion();

        $this->assertArrayHasKey('jsonrpc', $res);
        $this->assertArrayHasKey('id', $res);
        $this->assertArrayHasKey('result', $res);
        $this->assertIsString($res['result']);
    }
}