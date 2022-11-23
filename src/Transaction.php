<?php

namespace Fenshenx\PhpConfluxSdk;

use Elliptic\EC;
use Fenshenx\PhpConfluxSdk\Utils\FormatUtil;
use Fenshenx\PhpConfluxSdk\Utils\SignUtil;
use kornrunner\Keccak;
use kornrunner\Secp256k1;
use phpseclib3\Math\BigInteger;
use Web3p\RLP\RLP;

class Transaction
{
    public string $r;

    public string $s;

    public int $v;

    public function __construct(
        public string $from,
        public int|string $nonce,
        public Drip $gasPrice,
        public Drip $gas,
        public string $to,
        public Drip $value,
        public int|string|BigInteger $storageLimit,
        public int|string|BigInteger $epochHeight,
        public int $chainId,
        public string|null|int $data = 0
    )
    {
    }

    public function hash()
    {
        return FormatUtil::zeroPrefix($this->encode(true));
    }

    public function sign($privateKey)
    {
        $secp256k1 = new Secp256k1();
        $signed = $secp256k1->sign(FormatUtil::zeroPrefix(Keccak::hash(hex2bin($this->encode()), 256)), $privateKey);

        $this->r = FormatUtil::zeroPrefix(gmp_strval($signed->getR(), 16));
        $this->s = FormatUtil::zeroPrefix(gmp_strval($signed->getS(), 16));
        $this->v = $signed->getRecoveryParam();

        return $this;
    }

    private function encode($includeSignature = false)
    {
        $raw = [
            $this->nonce, $this->gasPrice->getDripHex(), $this->gas->getDripHex(), SignUtil::confluxAddress2Address($this->to),
            $this->value->getDripHex(), $this->getBitintVal($this->storageLimit), $this->getBitintVal($this->epochHeight),
            $this->chainId, $this->data ?? ''
        ];

        if ($includeSignature)
            $raw = [$raw, $this->v, $this->r, $this->s];

        $rlp = new RLP();

        return $rlp->encode($raw);
    }

    private function getBitintVal(int|string|BigInteger $value)
    {
        if ($value instanceof BigInteger)
            return FormatUtil::zeroPrefix($value->toHex());

        return $value;
    }
}