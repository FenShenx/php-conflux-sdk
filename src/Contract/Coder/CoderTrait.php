<?php

namespace Fenshenx\PhpConfluxSdk\Contract\Coder;

trait CoderTrait
{
    private string $type;

    private string|null $baseType = null;

    private int|null $bits = null;

    private bool $dynamic = false;

    public function getType()
    {
        return $this->type ?? '';
    }

    public function getBaseType()
    {
        return $this->baseType ?? $this->getType();
    }

    public function getBits()
    {
        return $this->bits;
    }

    public function getDynamic(): bool
    {
        return $this->dynamic;
    }
}