<?php

namespace Test\Unit;

use Fenshenx\PhpConfluxSdk\Conflux;
use Fenshenx\PhpConfluxSdk\Drip;
use Fenshenx\PhpConfluxSdk\Enums\EpochNumber;
use Fenshenx\PhpConfluxSdk\Utils\FormatUtil;
use phpseclib3\Math\BigInteger;
use Test\TestCase;

class CfxTest extends TestCase
{
    public function testGetClientVersion()
    {
        $cfx = $this->getCfx();

        $res = $cfx->clientVersion();

        $this->assertIsString($res);
    }

    public function testGetGasPrice()
    {
        $cfx = $this->getCfx();

        $res = $cfx->gasPrice();

        $this->assertInstanceOf(Drip::class, $res);
    }

    public function testEpochNumber()
    {
        $cfx = $this->getCfx();

        $tag1 = 97011356;
        $res1 = $cfx->epochNumber($tag1);
        $this->assertSame($tag1, (int)$res1->toString());

        foreach (EpochNumber::cases() as $tag) {

            $res = $cfx->epochNumber($tag);
            $this->assertInstanceOf(BigInteger::class, $res);
        }
    }

    public function testGetBalance()
    {
        $cfx = $this->getCfx();
        $address = "cfxtest:aatmav6mw5tps6h61jp5wb0xwdk9f649gew3m3a04t";

        $drip = $cfx->getBalance($address);
        $this->assertInstanceOf(Drip::class, $drip);

        $drip2 = $cfx->getBalance($address, EpochNumber::LatestConfirmed);
        $this->assertInstanceOf(Drip::class, $drip2);
    }

    public function testGetAdmin()
    {
        $cfx = $this->getCfx();
        $contractAddress = "cfxtest:acgdtuumgpwxpdmptxmmjdmcn64cbdx1yugj81phc4";
        $adminAddress = "cfxtest:aatz19y0y2r1db8hnryn2jh2msxb3zpjtpbxwwjp86";

        $res = $cfx->getAdmin($contractAddress);

        $this->assertSame($res, $adminAddress);
    }

    public function testGetSponsorInfo()
    {
        $cfx = $this->getCfx();
        $contractAddress = "cfxtest:acgdtuumgpwxpdmptxmmjdmcn64cbdx1yugj81phc4";

        $res = $cfx->getSponsorInfo($contractAddress);

        $this->assertIsString($res['sponsorForGas']);
        $this->assertIsString($res['sponsorForCollateral']);
        $this->assertInstanceOf(Drip::class, $res['sponsorGasBound']);
        $this->assertInstanceOf(Drip::class, $res['sponsorBalanceForGas']);
        $this->assertInstanceOf(Drip::class, $res['sponsorBalanceForCollateral']);
    }

    public function testGetStakingBalance()
    {
        $cfx = $this->getCfx();
        $address = "cfxtest:aatmav6mw5tps6h61jp5wb0xwdk9f649gew3m3a04t";

        $res = $cfx->getStakingBalance($address);

        $this->assertInstanceOf(Drip::class, $res);
    }

    public function testGetDepositList()
    {
        //TODO:
    }

    public function testGetVoteList()
    {
        //TODO:
    }

    public function testGetCollateralForStorage()
    {
        $cfx = $this->getCfx();

        $address = "cfxtest:acgdtuumgpwxpdmptxmmjdmcn64cbdx1yugj81phc4";
        $res = $cfx->getCollateralForStorage($address);

        $this->assertInstanceOf(Drip::class, $res);
    }

    public function testGetCode()
    {
        $cfx = $this->getCfx();

        $address = "cfxtest:acgdtuumgpwxpdmptxmmjdmcn64cbdx1yugj81phc4";
        $res = $cfx->getCode($address);

        $this->assertIsString($res);
        $this->assertSame(true, FormatUtil::isZeroPrefixed($res));
    }

    public function testGetStorageAt()
    {
        $cfx = $this->getCfx();

        $address = "cfxtest:acgdtuumgpwxpdmptxmmjdmcn64cbdx1yugj81phc4";
        $res = $cfx->getStorageAt($address, 256);

        $this->assertIsString($res);
    }

    public function testGetStorageRoot()
    {
        $cfx = $this->getCfx();

        $address = "cfxtest:acgdtuumgpwxpdmptxmmjdmcn64cbdx1yugj81phc4";
        $res = $cfx->getStorageRoot($address);

        if (!is_null($res['delta'])) {
            $this->assertIsString($res['delta']);
            $this->assertSame(true, FormatUtil::isZeroPrefixed($res['delta']));
        }

        if (!is_null($res['intermediate'])) {
            $this->assertIsString($res['intermediate']);
            $this->assertSame(true, FormatUtil::isZeroPrefixed($res['intermediate']));
        }

        if (!is_null($res['snapshot'])) {
            $this->assertIsString($res['snapshot']);
            $this->assertSame(true, FormatUtil::isZeroPrefixed($res['snapshot']));
        }
    }

    public function testGetBlockByHash()
    {
        $cfx = $this->getCfx();

        $blockHash = "0xc20b1a3aac892442a1bfa30b236877ced8b3084e584d7344b84c12b338ba72ea";
        $res = $cfx->getBlockByHash($blockHash, false);

        $this->assertSame($blockHash, $res["hash"]);
    }

    public function testGetBlockByHashWithPivotAssumption()
    {
        $cfx = $this->getCfx();

        $blockHash = "0xc20b1a3aac892442a1bfa30b236877ced8b3084e584d7344b84c12b338ba72ea";
        $epochNumber = "97140287";
        $res = $cfx->getBlockByHashWithPivotAssumption($blockHash, $blockHash, $epochNumber);

        $this->assertSame($blockHash, $res["hash"]);
    }

    public function testGetBlockByEpochNumber()
    {
        $cfx = $this->getCfx();
        $epochNumber = "97140287";
        $res1 = $cfx->getBlockByEpochNumber($epochNumber, false);

        $this->assertSame(FormatUtil::numberToHex($epochNumber, true), $res1["epochNumber"]);

        $res2 = $cfx->getBlockByEpochNumber(EpochNumber::LatestMined, false);
        $this->assertIsString($res2["epochNumber"]);
    }

    public function testGetBlockByBlockNumber()
    {
        $cfx = $this->getCfx();
        $blockNumber = "97140287";
        $res = $cfx->getBlockByBlockNumber($blockNumber, false);

        $this->assertSame(FormatUtil::numberToHex($blockNumber, true), $res["blockNumber"]);
    }

    public function testGetBestBlockHash()
    {
        $cfx = $this->getCfx();
        $res = $cfx->getBestBlockHash();

        $this->assertIsString($res);
        $this->assertTrue(FormatUtil::isZeroPrefixed($res));
    }

    public function testGetNextNonce()
    {
        $cfx = $this->getCfx();

        $address = "cfxtest:aatmav6mw5tps6h61jp5wb0xwdk9f649gew3m3a04t";
        $res = $cfx->getNextNonce($address);

        $this->assertInstanceOf(BigInteger::class, $res);
    }

    public function testGetStatus()
    {
        $cfx = $this->getCfx();

        $res = $cfx->getStatus();

        $this->assertIsString($res['bestHash']);
        $this->assertIsString($res['chainId']);
        $this->assertIsString($res['networkId']);
        $this->assertIsString($res['epochNumber']);
        $this->assertIsString($res['blockNumber']);
    }

    public function testEstimateGasAndCollateral()
    {
        $cfx = $this->getCfx();

        $options = [
            'from' => 'cfxtest:aatmav6mw5tps6h61jp5wb0xwdk9f649gew3m3a04t',
            'to' => 'cfxtest:aapr2jm67p5myymb51g0caszkred0907eayz84w6v3',
            'value' => Drip::fromCFX(1)
        ];
        $res = $cfx->estimateGasAndCollateral($options);

        $this->assertArrayHasKey('gasLimit', $res);
        $this->assertArrayHasKey('gasUsed', $res);
        $this->assertArrayHasKey('storageCollateralized', $res);
        $this->assertInstanceOf(Drip::class, $res['gasLimit']);
        $this->assertInstanceOf(Drip::class, $res['gasUsed']);
        $this->assertInstanceOf(Drip::class, $res['storageCollateralized']);
    }

    public function testSendTransaction()
    {
        $conflux = $this->getConflux();
        $conflux->getWallet()->addPrivateKey("0x634094445fad8532ab6742f9896c6e6de4e43d03145ea573e1d3c8c425aaa549");
        $options = [
            'from' => 'cfxtest:aatmav6mw5tps6h61jp5wb0xwdk9f649gew3m3a04t',
            'to' => 'cfxtest:aapr2jm67p5myymb51g0caszkred0907eayz84w6v3',
            'value' => Drip::fromCFX(1),
//            'nonce' => '0x03',
//            'gasPrice' => new Drip(new BigInteger('0x3b9aca00', 16)),
//            'gas' => new Drip(new BigInteger('0x5208', 16)),
//            'storageLimit' => 0,
//            'epochHeight' => '0x05e5efd6',
//            'chainId' => $this->networkId,
//            'data' => null
        ];

        $res = $conflux->getCfx()->sendTransaction($options);

        $this->assertIsString($res);
    }

    private function getCfx()
    {
        $conflux = $this->getConflux();
        $cfx = $conflux->getCfx();

        return $cfx;
    }

    private function getConflux()
    {
        return new Conflux($this->testHost, $this->networkId);
    }
}