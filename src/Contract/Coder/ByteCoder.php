<?php

namespace Fenshenx\PhpConfluxSdk\Contract\Coder;

class ByteCoder implements ICoder
{
    use CoderTrait;

    public function __construct(
        private string $type
    )
    {
        if (!preg_match('/^bytes([0-9]*)$/', $type, $byteArr))
            throw new \Exception('Type is not byte');

        $this->baseType = $byteArr[1];
        $this->bits = $byteArr[2];
    }

    public function encode($data)
    {
        // TODO: Implement encode() method.
    }

    public function decode($data)
    {
        // TODO: Implement decode() method.
    }
}