<?php

namespace Fenshenx\PhpConfluxSdk\Contract\Coder;

class ByteCoder implements ICoder
{
    use CoderTrait;

    public function __construct(
        private string $type
    )
    {
        var_dump($this->type);
        if (!preg_match('/^bytes([0-9]*)$/', $type, $byteArr))
            throw new \Exception('Type is not byte');

        $this->bits = $byteArr[1];
        $this->baseType = str_replace($this->type, $this->bits, '');
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