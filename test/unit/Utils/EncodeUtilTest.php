<?php

namespace Test\Unit\Utils;

use Fenshenx\PhpConfluxSdk\Utils\EncodeUtil;
use Test\TestCase;

class EncodeUtilTest extends TestCase
{
    public function testGetAddressType()
    {
        $address1 = "0x18dc215ceb36aa5141ddcd6101d54b483b7edd20";
        $res1 = EncodeUtil::getAddressType($address1);

        $this->assertSame(EncodeUtil::TYPE_USER, $res1);

        $address2 = "0x829dd8342c1c8a1fbafe9aaf507e99d6919fe8a1";
        $res2 = EncodeUtil::getAddressType($address2);

        $this->assertSame(EncodeUtil::TYPE_CONTRACT, $res2);
    }

    public function testEncodeCfxAddress()
    {
        $address1 = "0x18dc215ceb36aa5141ddcd6101d54b483b7edd20";
        $res1 = EncodeUtil::encodeCfxAddress($address1, $this->networkId);
        $this->assertSame("cfxtest:aapr2jm67p5myymb51g0caszkred0907eayz84w6v3", $res1);

        $res2 = EncodeUtil::encodeCfxAddress($address1, $this->networkId, true);
        $this->assertSame("CFXTEST:TYPE.USER:AAPR2JM67P5MYYMB51G0CASZKRED0907EAYZ84W6V3", $res2);

        // Contract
        $address2 = "0x829dd8342c1c8a1fbafe9aaf507e99d6919fe8a1";

        $res3 = EncodeUtil::encodeCfxAddress($address2, $this->networkId);
        $this->assertSame("cfxtest:acbk50byfusjyh7494rm8yd8xhnkdh9jyetgadzem4", $res3);

        $res4 = EncodeUtil::encodeCfxAddress($address2, $this->networkId, true);
        $this->assertSame("CFXTEST:TYPE.CONTRACT:ACBK50BYFUSJYH7494RM8YD8XHNKDH9JYETGADZEM4", $res4);
    }
}