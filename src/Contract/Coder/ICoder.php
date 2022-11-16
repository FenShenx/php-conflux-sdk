<?php

namespace Fenshenx\PhpConfluxSdk\Contract\Coder;

use Fenshenx\PhpConfluxSdk\Contract\HexStream;

interface ICoder
{
    public function getType();

    public function getBaseType();

    public function getBits();

    public function encode($data);

    public function decode(HexStream $data);
}