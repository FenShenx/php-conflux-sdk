<?php

namespace Fenshenx\PhpConfluxSdk\Contract\Coder;

class ArrayCoder implements ICoder
{
    use CoderTrait;

    private ICoder $coder;

    public function __construct(
        private string $type,
    )
    {
        if (!preg_match('/^(.*)\[([0-9]*)]$/', $this->type, $typeArr))
            throw new \Exception('Type is not array');

        $this->baseType = $typeArr[1];
        $this->coder = CoderFactory::generateCoder(['type' => $this->baseType]);
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