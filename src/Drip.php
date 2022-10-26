<?php

namespace Fenshenx\PhpConfluxSdk;

use phpseclib3\Math\BigInteger;

class Drip
{
    private BigInteger $drip;

    private static BigInteger $cfxE;

    private static BigInteger $gdripE;

    public function __construct(
        int|string|BigInteger $drip
    )
    {
        if ($drip instanceof BigInteger)
            $this->drip = clone $drip;
        else
            $this->drip = new BigInteger($drip);
    }

    public static function fromCFX($cfx)
    {
        self::initCfxE();

        $cfx = new BigInteger($cfx);

        return new static($cfx->multiply(self::$cfxE));
    }

    public static function fromGdrip($gdrip)
    {
        self::initGdripE();

        $gdrip = new BigInteger($gdrip);

        return new static($gdrip->multiply(self::$gdripE));
    }

    public function toCFX()
    {
        self::initCfxE();

        return $this->drive($this->drip, self::$cfxE);
    }

    public function toGdrip()
    {
        self::initGdripE();

        return $this->drive($this->drip, self::$gdripE);
    }

    private function drive(BigInteger $a, BigInteger $b)
    {
        $c = $a->divide($b);

        if ($c[1]->toString() == '0')
            return $c[0]->toString();

        return $c[0]->toString().'.'.$c[1]->toString();
    }

    public function getDrip()
    {
        return $this->drip->toString();
    }

    public function __toString(): string
    {
        return $this->getDrip();
    }

    private static function initCfxE()
    {
        if (empty(self::$cfxE))
            self::$cfxE = new BigInteger("1000000000000000000");
    }

    private static function initGdripE()
    {
        if (empty(self::$gdripE))
            self::$gdripE = new BigInteger("1000000000");
    }
}