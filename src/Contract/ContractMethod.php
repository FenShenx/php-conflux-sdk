<?php

namespace Fenshenx\PhpConfluxSdk\Contract;

use Fenshenx\PhpConfluxSdk\Contract\Coder\ICoder;

class ContractMethod
{
    /**
     * @var ICoder[]
     */
    private array $inputsCoders = [];

    /**
     * @var ICoder[]
     */
    private array $outputsCoders = [];

    public function __construct(
        private string $name,
        array $inputs = [],
        array $outputs = []
    )
    {

    }

    private function formatFullName($name, $inputs)
    {

    }

    private function formatType($name, $inputs)
    {

    }

    private function abi2Coder($abi)
    {

    }
}