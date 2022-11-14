<?php

namespace Fenshenx\PhpConfluxSdk\Contract;

interface IContractMethod
{
    /**
     * encode inputs
     * @param $data
     * @return mixed
     */
    public function encodeData($data);

    /**
     * decode outputs
     * @param $data
     * @return mixed
     */
    public function decodeData($data);
}