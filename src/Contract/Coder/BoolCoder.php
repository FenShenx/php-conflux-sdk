<?php

namespace Fenshenx\PhpConfluxSdk\Contract\Coder;

use Fenshenx\PhpConfluxSdk\Contract\HexStream;
use phpseclib3\Math\BigInteger;

class BoolCoder implements ICoder
{
    use CoderTrait;

    private ICoder $integerCoder;

    public function __construct(
        private string $type
    )
    {
        $this->integerCoder = new IntegerCoder('uint');
    }

    public function encode($data)
    {
        if (!is_bool($data))
            throw new \Exception('data must be boolean');

        return $this->integerCoder->encode($data ? 1 : 0);
    }

    public function decode(HexStream $data)
    {
        return $this->integerCoder->decode($data)->compare(new BigInteger(1)) === 0;
    }
}