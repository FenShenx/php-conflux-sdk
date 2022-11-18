<?php

namespace Test\Unit;

use Fenshenx\PhpConfluxSdk\Conflux;
use phpseclib3\Math\BigInteger;
use Test\TestCase;

class ContractTest extends TestCase
{
    private $fromAddress = "cfxtest:aatmav6mw5tps6h61jp5wb0xwdk9f649gew3m3a04t";

    private $fromPrivateKey = "0x634094445fad8532ab6742f9896c6e6de4e43d03145ea573e1d3c8c425aaa549";

    public function testGetAddress()
    {
        $contract = $this->getContract();

        $res = $contract->getAddress($this->fromAddress)->send();

        $this->assertSame($this->fromAddress, $res);
    }

    public function testGetUints()
    {
        $params = [new BigInteger(10), new BigInteger(100), new BigInteger(1000), new BigInteger(10000)];
        $contract = $this->getContract();

        $res = $contract->getUints(...$params)->send();

        /**
         * @var BigInteger $v
         */
        foreach (array_values($res) as $k => $v) {
            $this->assertSame($params[$k]->toHex(), $v->toHex());
        }

        $params2 = [10, 100, 1000, 10000];

        $res2 = $contract->getUints(...$params2)->send();
        /**
         * @var BigInteger $v
         */
        foreach (array_values($res2) as $k => $v) {
            $this->assertSame($params2[$k], (int)$v->toString());
        }
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