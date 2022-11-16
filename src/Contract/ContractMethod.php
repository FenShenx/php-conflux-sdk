<?php

namespace Fenshenx\PhpConfluxSdk\Contract;

use Fenshenx\PhpConfluxSdk\Contract\Coder\CoderFactory;
use Fenshenx\PhpConfluxSdk\Contract\Coder\ICoder;
use Fenshenx\PhpConfluxSdk\Contract\Coder\IntegerCoder;
use Fenshenx\PhpConfluxSdk\Utils\FormatUtil;
use kornrunner\Keccak;
use phpseclib3\Math\BigInteger;

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

    private ICoder $integerCoder;

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
        $this->integerCoder = new IntegerCoder('uint');
    }

    public function encodeInputs(array $inputs)
    {
        $data = $this->signature;

        if (!empty($inputs)) {
            //TODO
        }

        return FormatUtil::zeroPrefix($data);
    }

    public function decodeOutputs($outputs)
    {
        $hex = new HexStream($outputs);
        $startIndex = $hex->getCurrentIndex();

        $arr = array_map(function (ICoder $coder) use ($hex, $startIndex) {
            if ($coder->getDynamic()) {
                $offset = $this->integerCoder->decode($hex);
                return $offset->multiply(new BigInteger(2))->add(new BigInteger($startIndex));
            } else {
                return $coder->decode($hex);
            }
        }, array_values($this->outputsCoders));

        foreach (array_values($this->outputsCoders) as $k => $v) {
            if ($arr[$k] instanceof BigInteger) {
                if (((int)$arr[$k]->toString()) !== $hex->getCurrentIndex())
                    throw new \Exception('hex stream index error');

                $arr[$k] = $v->decode($hex);
            }
        }

        $arrLength = count($arr);

        if ($arrLength === 0)
            return;

        if ($arrLength === 1)
            return $arr[0];

        $resArr = [];
        $outputKeys = array_keys($this->outputsCoders);
        foreach ($arr as $k => $item) {
            $resArr[$outputKeys[$k]] = $item;
        }

        return $resArr;
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