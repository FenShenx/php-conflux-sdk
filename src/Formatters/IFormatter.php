<?php

namespace Fenshenx\PhpConfluxSdk\Formatters;

interface IFormatter
{
    public static function format($value);
}