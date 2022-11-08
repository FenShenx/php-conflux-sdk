<?php

namespace Test\Unit;

use Fenshenx\PhpConfluxSdk\Conflux;
use Fenshenx\PhpConfluxSdk\Drip;
use Fenshenx\PhpConfluxSdk\Transaction;
use phpseclib3\Math\BigInteger;
use Test\TestCase;

class TransactionTest extends TestCase
{
    public function testSign()
    {
        $chain = new Conflux($this->testHost, $this->networkId);
        $cfx = $chain->getCfx();

        $fromAddress = "cfxtest:aatmav6mw5tps6h61jp5wb0xwdk9f649gew3m3a04t";
        $fromPrivateKey = "634094445fad8532ab6742f9896c6e6de4e43d03145ea573e1d3c8c425aaa549";

        $toAddress = "cfxtest:aapr2jm67p5myymb51g0caszkred0907eayz84w6v3";

        $nonce = 3;
        $gasPrice = new Drip(new BigInteger("3b9aca00", 16));
        $gas = new Drip(21000);
        $value = Drip::fromCFX(1);
        $storageLimit = 0;
        $epochNumber = new BigInteger("05da1fcd", 16);
        $chainId = 1;
        $data = '';

        $transaction = new Transaction(
            $fromAddress, $nonce, $gasPrice, $gas, $toAddress, $value, $storageLimit, $epochNumber,
            $chainId, $data
        );

        $hash = $transaction->sign($fromPrivateKey)->hash();

        $this->assertSame("0x1652b027b3b8630f10297e8a0c4c33a87f58a1b055cfa46384b1d57f11b9a616", $hash);
    }
}