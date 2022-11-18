<?php

namespace Test\Unit;

use Fenshenx\PhpConfluxSdk\Conflux;
use Test\TestCase;

class ContractTest extends TestCase
{
    private function getContract()
    {
        $contractAddress = "cfxtest:acgh0vts2ga63dpwrbtzcgbz9m4x01bpkjwu9sufp4";

        $conflux = new Conflux($this->testHost, $this->networkId);
        $abi = json_decode(file_get_contents(__DIR__.'/../static/'.$contractAddress.'.json'), true);
        $contract = $conflux->getContract($abi, $contractAddress);

        return $contract;
    }
}