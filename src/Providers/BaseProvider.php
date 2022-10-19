<?php

namespace Fenshenx\PhpConfluxSdk\Providers;

abstract class BaseProvider implements IProvider
{
    protected string $url;

    protected int $timeout;

    public function __construct(string $url, int $timeout = 30 * 1000)
    {
        $this->url = $url;
        $this->timeout = $timeout;
    }

    abstract protected function request($data);

    abstract protected function getJsonRpcVersion(): string;

    public function send($method, $params)
    {
        return $this->sendRequest($method, $params);
    }

    public function call($method, $params)
    {
        return $this->sendRequest($method, $params);
    }

    public function batch(array $arr)
    {
        $returnArr = [];
        foreach ($arr as $item) {

            $returnArr[] = $this->sendRequest($item['method'], $item['params']);
        }

        return $returnArr;
    }

    protected function genRequestId(): string
    {
        return md5(microtime().rand(1, 999999));
    }

    private function sendRequest($method, $params)
    {
        $data = [
            "jsonrpc" => $this->getJsonRpcVersion(),
            'id' => $this->genRequestId(),
            "method" => $method,
            "params" => $params
        ];

        return $this->request($data);
    }
}