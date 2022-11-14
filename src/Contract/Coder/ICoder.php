<?php

namespace Fenshenx\PhpConfluxSdk\Contract\Coder;

interface ICoder
{
    public function getType();

    public function getBaseType();

    public function getBits();

    public function encode($data);

    public function decode($data);
}