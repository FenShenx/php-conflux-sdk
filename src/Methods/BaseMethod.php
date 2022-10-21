<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\IFormatter;
use Fenshenx\PhpConfluxSdk\Providers\IProvider;

abstract class BaseMethod implements IMethod
{
    protected IProvider $provider;

    /**
     * @var IFormatter[]
     */
    protected array $requestFormatters = [];

    /**
     * @var IFormatter[]
     */
    protected array $responseFormatters = [];

    protected string $methodName;

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

    abstract protected function formatResponse($response);

    protected function formatRequest($payload)
    {
        foreach ($payload as $k => $v) {

            if (key_exists($k, $this->requestFormatters))
                $payload[$k] = $this->requestFormatters[$k]->format($v);
        }

        return $payload;
    }

    public function send()
    {
        $payload = $this->formatRequest($this->getPayload());

        $res = $this->provider->send($this->getMethodName(), $payload);

        return $this->formatResponse($res['result']);
    }
}