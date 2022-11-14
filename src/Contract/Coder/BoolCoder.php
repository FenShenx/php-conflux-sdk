<?php

namespace Fenshenx\PhpConfluxSdk\Contract\Coder;

class BoolCoder implements ICoder
{
    use CoderTrait;

    public function __construct(
        private string $type
    )
    {

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