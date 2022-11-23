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

        $this->assertSame("0xf873ef03843b9aca008252089418dc215ceb36aa5141ddcd6101d54b483b7edd20880de0b6b3a7640000808405da1fcd018001a0adaa362e65a002acfd9a3f4fc4e74f1b10ac6ee21c058eb2a868a605969f408ca0549c0a07036bf1a98d069089668907a1188fdb61fb0149f4ff8cc54e2c791769", $hash);
    }
}