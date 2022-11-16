<?php

namespace Fenshenx\PhpConfluxSdk\Contract\Coder;

use Fenshenx\PhpConfluxSdk\Contract\HexStream;
use phpseclib3\Math\BigInteger;

class IntegerCoder implements ICoder
{
    use CoderTrait;

    private int $size;

    private BigInteger $bound;

    public function __construct(
        private string $type,
        private bool $signed = false
    )
    {
        if (!preg_match('/^(int|uint)([0-9]*)$/', $type, $typeArr))
            throw new \Exception('Type is not int/uint');

        $this->baseType = $typeArr[1];
        $this->bits = empty($typeArr[2]) ? 256 : (int)$typeArr[2];
        $this->size = $this->bits / 8;

        $bound = new BigInteger(1);
        $this->bound = $bound->bitwise_leftShift($this->bits - ($this->signed ? 1 : 0));
    }

    public function encode($data)
    {
        // TODO: Implement encode() method.
    }

    public function decode(HexStream $data)
    {
        $value = new BigInteger($data->read($this->size * 2), 16);

        if ($this->signed && $value->compare($this->bound) >= 0) {

            $mask = new BigInteger(1);
            $mask = $mask->bitwise_leftShift($this->size * 8);

            $value = $value->subtract($mask);
        }

        return $value;
    }
}