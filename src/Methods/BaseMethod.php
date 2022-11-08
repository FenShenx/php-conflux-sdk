<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Formatters\IFormatter;
use Fenshenx\PhpConfluxSdk\Providers\IProvider;

abstract class BaseMethod implements IMethod
{
    protected IProvider $provider;

    protected string $methodName;

    protected array $params = [];

    /**
     * @var IFormatter[]
     */
    protected array $requestFormatters = [];

    /**
     * @var IFormatter[]
     */
    protected array $responseFormatters = [];

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

    protected function getPayload()
    {
        return $this->params;
    }

    abstract protected function validate($params);

    protected function formatRequest($payload)
    {
        if (!empty($this->requestFormatters))
            $payload = $this->format($payload, $this->requestFormatters);

        return $payload;
    }

    protected function formatResponse($response)
    {
        if (!empty($this->responseFormatters)) {
            if (is_array($response)) {

                if (empty($response)) {
                    //Do nothing
                } elseif (array_keys($response) !== range(0, count($response)-1)) {
                    $response = $this->format($response, $this->responseFormatters);
                } else {

                    foreach ($response as $k => $item) {
                        $response[$k] = $this->format($item, $this->responseFormatters);
                    }
                }

            } else {
                $response = $this->format([$response], $this->responseFormatters)[0];
            }
        }

        return $response;
    }

    /**
     * @param $data
     * @param IFormatter[] $rules
     * @return mixed
     */
    private function format($data, $rules)
    {
        foreach ($data as $k => $v) {
            if (array_key_exists($k, $rules)) {
                if (is_array($rules[$k]))
                    $data[$k] = $this->format($data[$k], $rules[$k]);
                else
                    $data[$k] = $rules[$k]::format($v);
            }
        }

        return $data;
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