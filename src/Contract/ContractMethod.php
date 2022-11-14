<?php

namespace Fenshenx\PhpConfluxSdk\Contract;

use Fenshenx\PhpConfluxSdk\Contract\Coder\CoderFactory;
use Fenshenx\PhpConfluxSdk\Contract\Coder\ICoder;
use kornrunner\Keccak;

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

    private string $type;

    private string $signature;

    public function __construct(
        private string $name,
        private string $stateMutability = 'nonpayable',
        array $inputs = [],
        array $outputs = [],
        private bool $anonymous = false
    )
    {
        $this->inputsCoders = $this->abis2Coder($inputs);
        $this->outputsCoders = $this->abis2Coder($outputs);
        $this->type = $this->formatType($this->name, array_values($this->inputsCoders));
        $this->signature = substr(Keccak::hash($this->type, 256), 0,10);
    }

    public function encodeInputs($inputs)
    {
        //TODO
    }

    public function decodeOutputs($outputs)
    {
        //TODO
    }

    /**
     * @param string $name
     * @param ICoder[] $coders
     * @return string
     */
    private function formatType($name, $coders)
    {
        $argTypes = [];
        foreach ($coders as $coder) {
            $argTypes[] = $coder->getType();
        }

        return $name.'('.implode(',', $argTypes).')';
    }

    private function abis2Coder($abis)
    {
        $res = [];
        foreach ($abis as $abi) {
            $res[$abi['name']] = $this->abi2Code($abi);
        }

        return $res;
    }

    private function abi2Code($abi)
    {
        return CoderFactory::generateCoder($abi);
    }
}