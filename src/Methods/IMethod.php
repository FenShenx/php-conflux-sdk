<?php

namespace Fenshenx\PhpConfluxSdk\Methods;

use Fenshenx\PhpConfluxSdk\Providers\IProvider;

interface IMethod
{
    public function __construct(IProvider $provider);

    public function setParams($params);

    public function send();
}