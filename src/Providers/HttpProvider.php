<?php

namespace Fenshenx\PhpConfluxSdk\Providers;

use Fenshenx\PhpConfluxSdk\Providers\Exceptions\HttpJsonRpcErrorException;
use GuzzleHttp\Client;

class HttpProvider extends BaseProvider
{
    protected function request($data)
    {
        $client = new Client([
            'timeout' => $this->timeout,
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);

        $response = $client->post($this->url, ['json' => $data]);

        $body = json_decode($response->getBody(), true);

        if (isset($body['error']))
            throw new HttpJsonRpcErrorException($body['error']['message'].' '.$body['error']['data'] ?? '', $body['error']['code']);

        return $body;
    }
}