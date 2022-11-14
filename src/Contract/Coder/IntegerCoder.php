<?php

namespace Fenshenx\PhpConfluxSdk\Contract\Coder;

class IntegerCoder implements ICoder
{
    use CoderTrait;

    public function __construct(
        private string $type
    )
    {
        if (!preg_match('/^(int|uint)([0-9]*)$/', $type, $typeArr))
            throw new \Exception('Type is not int/uint');

        $this->baseType = $typeArr[1];
        $this->bits = $typeArr[2];
    }

    public function encode($data)
    {
        // TODO: Implement encode() method.
    }

    public function decode($data)
    {
        // TODO: Implement decode() method.
    }

    public function getType()
    {
        // TODO: Implement getType() method.
    }

    public function getBaseType()
    {
        // TODO: Implement getBaseType() method.
    }

    public function getBits()
    {
        // TODO: Implement getBits() method.
    }
}