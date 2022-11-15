<?php

namespace Test\Unit;

use Fenshenx\PhpConfluxSdk\Conflux;
use Test\TestCase;

class ContractTest extends TestCase
{
    public function testName()
    {
        $contract = $this->getContract();

        $name = $contract->name()->send();
        var_dump($name);

        $this->assertSame("Guochao UAT", $name);
    }

    private function getContract()
    {
        $contractAddress = "cfxtest:ace585c5b1bbgvdjnzgasyj8r987j7b3uuayypyj16";

        $conflux = new Conflux($this->testHost, $this->networkId);
        $abi = json_decode(file_get_contents(__DIR__.'/../static/'.$contractAddress.'.json'), true);
        $contract = $conflux->getContract($abi, $contractAddress);

        return $contract;
    }
}