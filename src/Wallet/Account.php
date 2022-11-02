<?php

namespace Fenshenx\PhpConfluxSdk\Wallet;

use Fenshenx\PhpConfluxSdk\Utils\FormatUtil;
use Fenshenx\PhpConfluxSdk\Utils\SignUtil;

class Account
{
    private string $privateKey;

    private string $publicKey;

    private string $address;

    private string $confluxAddress;

    public function __construct(
        string $privateKey,
        private int $networkId
    )
    {
        $this->privateKey = FormatUtil::zeroPrefix($privateKey);
        $this->publicKey = SignUtil::privateKey2PublicKey($privateKey);
        $this->address = SignUtil::publicKey2Address($this->publicKey);
        $this->confluxAddress = SignUtil::publicKey2ConfluxAddress($this->publicKey, $this->networkId);
    }

    public static function random($networkId)
    {
        $privateKey = SignUtil::getRandomPrivateKey();

        return new self($privateKey, $networkId);
    }

    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    public function getPublicKey()
    {
        return $this->publicKey;
    }

    public function getHexAddress()
    {
        return $this->address;
    }

    public function getConfluxAddress()
    {
        return $this->confluxAddress;
    }

    public function signTransaction($options)
    {

    }

    public function signMessage($options)
    {

    }
}