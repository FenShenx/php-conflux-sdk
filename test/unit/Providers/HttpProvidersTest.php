<?php

namespace Test\Unit\Providers;

use Fenshenx\PhpConfluxSdk\Providers\Exceptions\HttpJsonRpcErrorException;
use Fenshenx\PhpConfluxSdk\Providers\HttpProvider;
use Test\TestCase;

final class HttpProvidersTest extends TestCase
{
    public function testSend()
    {
        $provider = new HttpProvider($this->testHost);
        $res = $provider->send('cfx_clientVersion', []);

        $this->assertSame($res['jsonrpc'], $provider->getJsonRpcVersion());
    }

    public function testCall()
    {
        $provider = new HttpProvider($this->testHost);
        $res = $provider->send('cfx_clientVersion', []);

        $this->assertSame($res['jsonrpc'], $provider->getJsonRpcVersion());
    }

    public function testBatch()
    {
        $provider = new HttpProvider($this->testHost);

        $arr = [
            ['method' => 'cfx_clientVersion', 'params' => []],
            ['method' => 'cfx_clientVersion', 'params' => []],
        ];

        $resArr = $provider->batch($arr);

        foreach ($resArr as $item) {
            $this->assertSame($item['jsonrpc'], $provider->getJsonRpcVersion());
        }
    }

    public function testSendException()
    {
        $this->expectException(HttpJsonRpcErrorException::class);

        $provider = new HttpProvider($this->testHost);
        $provider->send('cfx_clientVersion1', []);
    }
}