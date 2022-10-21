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

        $this->assertIsString($res);
    }
}