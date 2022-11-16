<?php

namespace Fenshenx\PhpConfluxSdk\Contract\Coder;

class StringCoder extends ByteCoder
{
    use CoderTrait;

    public function __construct(
        private string $type
    )
    {
        parent::__construct('bytes');
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