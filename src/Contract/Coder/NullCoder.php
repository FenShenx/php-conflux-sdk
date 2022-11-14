<?php

namespace Fenshenx\PhpConfluxSdk\Contract\Coder;

class NullCoder implements ICoder
{
    use CoderTrait;

    public function __construct()
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