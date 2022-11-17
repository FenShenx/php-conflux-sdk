<?php

namespace Fenshenx\PhpConfluxSdk\Contract;

use Fenshenx\PhpConfluxSdk\Conflux;

class Contract
{
    /**
     * @var ContractMethod[]
     */
    private array $methods = [];

    public function __construct(
        private Conflux $conflux,
        private string $address,
        string|array $abis
    )
    {
        if (!is_string($abis) && !is_array($abis))
            throw new \Exception('abis must be json string or array');

        if (is_string($abis))
            $abis = json_decode($abis, true);

        foreach ($abis as $abi) {
            $this->methods[$abi['name']] = new ContractMethod(
                $abi['name'],
                $abi['stateMutability'] ?? 'nonpayable',
                $abi['inputs'] ?? [],
                $abi['outputs'] ?? [],
                $abi['anonymous'] ?? false
            );
        }
    }

    public function __call(string $name, array $arguments)
    {
        if (!isset($this->methods[$name]))
            throw new \Exception("Undefined method ".$name);

        $method = $this->methods[$name];

        return new MethodTransaction($this->conflux, $method, $this->address, $arguments);
    }
}