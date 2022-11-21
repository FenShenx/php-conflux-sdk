<?php

namespace Test\Unit;

use Fenshenx\PhpConfluxSdk\Conflux;
use Fenshenx\PhpConfluxSdk\Drip;
use Fenshenx\PhpConfluxSdk\Utils\SignUtil;
use phpseclib3\Math\BigInteger;
use Test\TestCase;

class ContractTest extends TestCase
{
    private $fromAddress = "cfxtest:aatmav6mw5tps6h61jp5wb0xwdk9f649gew3m3a04t";

    private $fromPrivateKey = "0x634094445fad8532ab6742f9896c6e6de4e43d03145ea573e1d3c8c425aaa549";

    private Conflux $conflux;

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

    public function testGetBytes()
    {
        $params = ['0x64', '0x65', '0x66'];
        $contract = $this->getContract();

        $res = $contract->getBytes(...$params)->send();
        $resAssert = [
            '0x64',
            '0x65000000000000000000000000000000',
            '0x6600000000000000000000000000000000000000000000000000000000000000'
        ];

        foreach (array_values($res) as $k => $v) {

            $this->assertSame($resAssert[$k], $v);
        }
    }

    public function testGetString()
    {
        $param = 'abcdefghijklmn';
        $contract = $this->getContract();

        $res = $contract->getString($param)->send();

        $this->assertSame($param, $res);
    }

    public function testGetBool()
    {
        $param = true;
        $contract = $this->getContract();

        $res = $contract->getBool($param)->send();

        $this->assertSame($param, $res);

        $param2 = false;

        $res2 = $contract->getBool($param2)->send();

        $this->assertSame($param2, $res2);
    }

    public function testGetUintArr()
    {
        $param = [1, 2, 3, 10, 20, 30];
        $contract = $this->getContract();

        $res = $contract->getUintArr($param)->send();

        foreach (array_values($res) as $k => $v) {
            $this->assertSame($param[$k], (int)$v->toString());
        }
    }

    public function testGetAddressArr()
    {
        $param = [
            $this->fromAddress,
            $this->fromAddress,
            $this->fromAddress
        ];
        $contract = $this->getContract();

        $res = $contract->getAddressArr($param)->send();

        foreach ($res as $k => $v) {
            $this->assertSame(SignUtil::confluxAddress2Address($param[$k]), $v);
        }
    }

    public function testMint()
    {
        $params = [$this->fromAddress, 1000];
        $contract = $this->getContract();
        $account = $this->getAccount();

        $gas = $contract->mint(...$params)->estimateGasAndCollateral($account);
        $this->assertArrayHasKey('gasLimit', $gas);
        $this->assertArrayHasKey('gasUsed', $gas);
        $this->assertArrayHasKey('storageCollateralized', $gas);
        $this->assertInstanceOf(Drip::class, $gas['gasLimit']);
        $this->assertInstanceOf(Drip::class, $gas['gasUsed']);
        $this->assertInstanceOf(Drip::class, $gas['storageCollateralized']);

        $hash = $contract->mint(...$params)->sendTransaction($account);
//        var_dump($hash);

        $this->assertIsString($hash);
    }

    public function testBalanceOf()
    {
        $contract = $this->getContract();

        $res = $contract->balanceOf($this->fromAddress)->send();

        $this->assertInstanceOf(BigInteger::class, $res);
    }

    public function testSend()
    {
        $contract = $this->getContract();
        $account = $this->getAccount();

        $hash = $contract->send('cfxtest:aapr2jm67p5myymb51g0caszkred0907eayz84w6v3', 100)->sendTransaction($account);

        $this->assertIsString($hash);
    }

    private function getAccount()
    {
        if (empty($this->conflux))
            $this->conflux = new Conflux($this->testHost, $this->networkId);

        $account = $this->conflux->getWallet()->addPrivateKey($this->fromPrivateKey);

        return $account;
    }

    private function getContract()
    {
        $contractAddress = "cfxtest:acgh0vts2ga63dpwrbtzcgbz9m4x01bpkjwu9sufp4";

        if (empty($this->conflux))
            $this->conflux = new Conflux($this->testHost, $this->networkId);

        $abi = json_decode(file_get_contents(__DIR__.'/../static/'.$contractAddress.'.json'), true);
        $contract = $this->conflux->getContract($abi, $contractAddress);

        return $contract;
    }
}