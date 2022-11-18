<?php

namespace Test\Unit;

use Fenshenx\PhpConfluxSdk\Conflux;
use Test\TestCase;

class ContractTest extends TestCase
{
    private $fromAddress = "cfxtest:aatmav6mw5tps6h61jp5wb0xwdk9f649gew3m3a04t";

    private $fromPrivateKey = "0x634094445fad8532ab6742f9896c6e6de4e43d03145ea573e1d3c8c425aaa549";

    public function testGetAddress()
    {
        $contract = $this->getContract();

        $res = $contract->getAddress($this->fromAddress)->send();
        var_dump($res);

        $this->assertSame($this->fromAddress, $res);
    }

    private function getContract()
    {
        $contractAddress = "cfxtest:acgh0vts2ga63dpwrbtzcgbz9m4x01bpkjwu9sufp4";

        $conflux = new Conflux($this->testHost, $this->networkId);
        $abi = json_decode(file_get_contents(__DIR__.'/../static/'.$contractAddress.'.json'), true);
        $contract = $conflux->getContract($abi, $contractAddress);

        return $contract;
    }
}