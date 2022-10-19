<?php

namespace Fenshenx\PhpConfluxSdk\Providers;

interface IProvider
{
    /**
     * Send a json rpc method request
     * @param $method
     * @param $params
     * @return mixed
     */
    public function send($method, $params);

    /**
     * Call a json rpc method request
     * @param $method
     * @param $params
     * @return mixed
     */
    public function call($method, $params);

    /**
     * Batch call json rpc methods with params
     * @param array $arr
     * @return mixed
     * @example provider.batch([["method" => "cfx_clientVersion", "params" => []], ["method" => "cfx_clientVersion", "params" => []]])
     */
    public function batch(array $arr);
}