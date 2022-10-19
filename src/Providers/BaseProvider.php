<?php

namespace Fenshenx\PhpConfluxSdk\Providers;

use Fenshenx\PhpConfluxSdk\Providers\Exceptions\JsonRpcErrorException;
use Psr\Log\LoggerInterface;

abstract class BaseProvider implements IProvider
{
    protected string $url;

    protected int $timeout;

    protected LoggerInterface $logger;

    private $version = "2.0";

    public function __construct(string $url, int $timeout = 30 * 1000, LoggerInterface $logger = null)
    {
        $this->url = $url;
        $this->timeout = $timeout;
        $this->logger = $logger;
    }

    /**
     * @param $data
     * @return mixed
     * @throws JsonRpcErrorException
     */
    abstract protected function request($data);

    private function getJsonRpcVersion(): string
    {
        return $this->version;
    }

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