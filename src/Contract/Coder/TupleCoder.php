<?php

namespace Fenshenx\PhpConfluxSdk\Contract\Coder;

class TupleCoder implements ICoder
{
    use CoderTrait;

    public function __construct(
        private string $type
    )
    {

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