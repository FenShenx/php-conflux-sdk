<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\IFormatter;
use Fenshenx\PhpConfluxSdk\Providers\IProvider;

abstract class BaseMethod implements IMethod
{
    protected IProvider $provider;

    protected string $methodName;

    protected array $params;

    public function __construct(IProvider $provider)
    {
        $this->provider = $provider;
    }

    protected function getMethodName()
    {
        if (empty($this->methodName))
            throw new \Exception('Please set $methodName');

        return $this->methodName;
    }

    abstract protected function getPayload();

    abstract protected function validate($params);

    protected function formatRequest($payload)
    {
        return $payload;
    }

    protected function formatResponse($response)
    {
        return $response;
    }

    public function send()
    {
        $payload = $this->formatRequest($this->getPayload());

        $res = $this->provider->send($this->getMethodName(), $payload);

        return $this->formatResponse($res['result']);
    }

    public function setParams($params)
    {
        $this->validate($params);

        $this->params = $params;
    }
}