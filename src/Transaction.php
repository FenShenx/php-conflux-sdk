<?php

namespace Fenshenx\PhpConfluxSdk;

use Elliptic\EC;
use Fenshenx\PhpConfluxSdk\Utils\FormatUtil;
use kornrunner\Keccak;
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
        return FormatUtil::zeroPrefix(Keccak::hash($this->encode(true), 256));
    }

    public function sign($privateKey)
    {
        $ec = new EC('secp256k1');
        $signed = $ec->sign(Keccak::hash($this->encode(), 256), $privateKey);

        $this->r = $signed['r'];
        $this->s = $signed['s'];
        $this->v = $signed['recoveryParam'];

        return $this;
    }

    public function recover()
    {
        //TODO
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