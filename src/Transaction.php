<?php

namespace Fenshenx\PhpConfluxSdk;

use Elliptic\EC;
use Fenshenx\PhpConfluxSdk\Utils\FormatUtil;
use Fenshenx\PhpConfluxSdk\Utils\SignUtil;
use kornrunner\Keccak;
use phpseclib3\Math\BigInteger;
use Web3p\RLP\RLP;

class Transaction
{
    public string $r;

    public string $s;

    public int $v;

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
        public string $data
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
        $signed = $ec->sign(FormatUtil::zeroPrefix(Keccak::hash(hex2bin($this->encode()), 256)), $privateKey);

        $res = new EC\Signature($signed);
        $res->s = $res->s->neg()->add($ec->n);
        $signed = $res;
//        var_dump(Keccak::hash(hex2bin($this->encode()), 256));die();
        var_dump($signed);die();
        $this->r = FormatUtil::zeroPrefix($signed->r->toString());
        $this->s = FormatUtil::zeroPrefix($signed->s->toString());
        $this->v = $signed->recoveryParam;

        return $this;
    }

    public function recover()
    {
        //TODO
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

        var_dump($rlp->encode($raw));
        return $rlp->encode($raw);
    }

    private function getBitintVal(int|string|BigInteger $value)
    {
        if ($value instanceof BigInteger)
            return FormatUtil::zeroPrefix($value->toHex());

        return $value;
    }
}