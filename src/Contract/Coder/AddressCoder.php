<?php

namespace Fenshenx\PhpConfluxSdk\Contract\Coder;

class AddressCoder implements ICoder
{
    use CoderTrait;

    public function __construct(
        private string $type,
        private int $networkId
    )
    {
        if ($this->type !== 'address')
            throw new \Exception('Type is not address');
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