<?php

namespace Fenshenx\PhpConfluxSdk\Providers;

use Fenshenx\PhpConfluxSdk\Providers\Exceptions\ProviderException;

class ProviderFactory
{
    public static function getProvider($url, $params = []): IProvider
    {
        if (str_contains($url, "http"))
            return new HttpProvider($url, ...$params);

        if (str_contains($url, 'ws'))
            throw new \Exception("WS client in development...");

        throw new ProviderException("Invalid provider url");
    }
}