<?php

namespace Fenshenx\PhpConfluxSdk\Contract\Coder;

use Fenshenx\PhpConfluxSdk\Contract\HexStream;
use Fenshenx\PhpConfluxSdk\Utils\FormatUtil;

class ByteCoder implements ICoder
{
    use CoderTrait;

    private ICoder $integerCoder;

    public function __construct(
        private string $type
    )
    {
        if (!preg_match('/^bytes([0-9]*)$/', $type, $byteArr))
            throw new \Exception('Type is not byte');

        $this->bits = ((int)$byteArr[1]) ?? null;
        $this->baseType = str_replace($this->type, $this->bits, '');
        $this->integerCoder = new IntegerCoder('uint');
        $this->dynamic = empty($this->bits);
    }

    public function encode($data)
    {
        // TODO: Implement encode() method.
    }

    public function decode(HexStream $data)
    {
        $length = $this->getBits() ?? (int)$this->integerCoder->decode($data)->toString();

        $bytesHex = $data->read($length * 2, true);

        return FormatUtil::zeroPrefix($bytesHex);
    }
}