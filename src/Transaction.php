<?php

namespace Fenshenx\PhpConfluxSdk;

use Fenshenx\PhpConfluxSdk\Utils\FormatUtil;
use phpseclib3\Math\BigInteger;
use Web3p\RLP\RLP;

class Transaction
{
    public function __construct(
        public string $from,
        public int $nonce,
        public Drip $gasPrice,
        public Drip $gas,
        public string $to,
        public Drip $value,
        public int|string|BigInteger $storageLimit,
        public int|string|BigInteger $epochHeight,
        public int $chainId,
        public string $data,
        public string $r,
        public string $s,
        public int $v
    )
    {
    }

    public function hash()
    {

    }

    public function sign($privateKey, $networkId)
    {

    }

    public function recover()
    {

    }

    private function encode($includeSignature = false)
    {
        $raw = [
            $this->nonce, $this->gasPrice->getDrip(), $this->gas->getDrip(), FormatUtil::zeroPrefix($this->to),
            $this->value->getDrip(), $this->getBitintVal($this->storageLimit), $this->getBitintVal($this->epochHeight),
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
            return $value->toString();

        return $value;
    }
}