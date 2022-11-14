<?php

namespace Fenshenx\PhpConfluxSdk\Contract\Coder;

interface ICoder
{
    public function encode($data);

    public function decode($data);
}