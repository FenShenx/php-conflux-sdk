<?php

namespace Fenshenx\PhpConfluxSdk\Formatters;

use phpseclib3\Math\BigInteger;

class BigNumberFormatter implements IFormatter
{

    public function format($value)
    {
        return new BigInteger((string)$value, 16);
    }
}