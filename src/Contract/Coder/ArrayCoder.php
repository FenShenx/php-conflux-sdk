<?php

namespace Fenshenx\PhpConfluxSdk\Contract\Coder;

use Fenshenx\PhpConfluxSdk\Contract\ContractMethod;
use Fenshenx\PhpConfluxSdk\Contract\HexStream;
use Fenshenx\PhpConfluxSdk\Utils\FormatUtil;

class ArrayCoder implements ICoder
{
    use CoderTrait;

    private ICoder $coder;

    private ICoder $integerCoder;

    private int|null $size = null;

    public function __construct(
        private string $type,
    )
    {
        if (!preg_match('/^(.*)\[([0-9]*)]$/', $this->type, $typeArr))
            throw new \Exception('Type is not array');

        $this->baseType = $typeArr[1];
        $this->coder = CoderFactory::generateCoder(['type' => $this->baseType]);
        $this->size = $typeArr[2] == '' ? null : (int)$typeArr[2];
        $this->dynamic = is_null($this->size) || $this->coder->getDynamic();
        $this->integerCoder = new IntegerCoder('uint');
    }

    public function encode($data)
    {
        if (!is_array($data))
            throw new \Exception('data must be array');

        if (!is_null($this->size) && $this->size !== count($data))
            throw new \Exception('length not match');

        $coders = $this->genCodersArr(count($data));

        $buffer = ContractMethod::encode($coders, $data);
        if (is_null($this->size)) {
            $buffer = $this->integerCoder->encode(count($data)).FormatUtil::stripZero($buffer);
        }

        return $buffer;
    }

    public function decode(HexStream $data)
    {
        $length = $this->size;

        if (empty($length))
            $length = (int)$this->integerCoder->decode($data)->toString();

        $coders = $this->genCodersArr($length);

        return ContractMethod::decode($coders, $data);
    }

    private function genCodersArr($len)
    {
        return array_map(function ($i) {
            return $this->coder;
        }, range(0, $len - 1));
    }
}