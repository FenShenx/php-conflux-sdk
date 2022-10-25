<?php

namespace Fenshenx\PhpConfluxSdk;

use phpseclib3\Math\BigInteger;

class Drip
{
    private BigInteger $drip;

    private BigInteger $cfxE;

    private BigInteger $gdripE;

    public function __construct(
        int|string|BigInteger $drip
    )
    {
        if ($drip instanceof BigInteger)
            $this->drip = clone $drip;
        else
            $this->drip = new BigInteger($drip);

        $this->cfxE = new BigInteger("1000000000000000000");
        $this->gdripE = new BigInteger("1000000000");
    }

    public static function __callStatic($name, $arguments)
    {
        $methods = [
            'fromCFX', 'fromGdrip'
        ];

        if (!in_array($name, $methods))
            throw new \Exception("Undefined method ".$name);

        $drip = new static(0);
        $drip->$name(...$arguments);

        return $drip;
    }

    public function fromCFX($cfx)
    {
        $cfx = new BigInteger($cfx);

        return new static($cfx->multiply($this->cfxE));
    }

    public function fromGdrip($gdrip)
    {
        $gdrip = new BigInteger($gdrip);

        return new static($gdrip->multiply($this->gdripE));
    }

    public function toCFX()
    {
        return $this->drip->divide($this->cfxE);
    }

    public function toGdrip()
    {
        return $this->drip->divide($this->gdripE);
    }

    public function getDrip()
    {
        return $this->drip->toString();
    }

    public function __toString(): string
    {
        return $this->getDrip();
    }
}