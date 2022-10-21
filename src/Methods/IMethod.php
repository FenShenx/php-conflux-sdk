<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

interface IMethod
{
    public function setParams($params);

    public function getMethodName(): string;

    public function getMethodPayload(): array;
}