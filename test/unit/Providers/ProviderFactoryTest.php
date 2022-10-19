<?php

namespace Test\Unit\Providers;

use Fenshenx\PhpConfluxSdk\Providers\Exceptions\ProviderException;
use Fenshenx\PhpConfluxSdk\Providers\HttpProvider;
use Fenshenx\PhpConfluxSdk\Providers\ProviderFactory;
use Test\TestCase;

class ProviderFactoryTest extends TestCase
{
    public function testGetHttpProvider()
    {
        $provider = ProviderFactory::getProvider($this->testHost);

        $this->assertInstanceOf(HttpProvider::class, $provider);
    }

    public function testGetWebsocketProvider()
    {
        $this->expectExceptionMessage('WS client in development...');

        ProviderFactory::getProvider('ws://localhost');
    }

    public function testGetFailProvider()
    {
        $this->expectException(ProviderException::class);

        ProviderFactory::getProvider('niubi666');
    }
}