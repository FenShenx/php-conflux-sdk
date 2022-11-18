<?php

namespace Fenshenx\PhpConfluxSdk\Contract\Coder;

use Fenshenx\PhpConfluxSdk\Contract\HexStream;
use Fenshenx\PhpConfluxSdk\Utils\EncodeUtil;
use phpseclib3\Math\BigInteger;

class IntegerCoder implements ICoder
{
    use CoderTrait;

    private int $size;

    private BigInteger $bound;

    private BigInteger $uintBound;

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

        $uintBound = new BigInteger(1);
        $this->uintBound = $uintBound->bitwise_leftShift(EncodeUtil::WORD_BYTES * 8);
    }

    public function encode($data)
    {
        if ($data instanceof BigInteger)
            $number = $data;
        else
            $number = new BigInteger($data);

        $twosComplement = clone $number;

        if ($this->signed && $number->compare(new BigInteger(0)) < 0) {
            $twosComplement = $number->add($this->bound);
            $number = $number->add($this->uintBound);
        }

        if ((new BigInteger(0))->compare($twosComplement) <= 0 && $twosComplement->compare($this->bound) < 0)
            return HexStream::alignHex($number->toHex());

        throw new \Exception('bound error');
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