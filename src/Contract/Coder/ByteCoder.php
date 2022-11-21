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

        $this->bits = empty($byteArr[1]) ? null : ((int)$byteArr[1]);
        $this->baseType = str_replace($this->type, $this->bits ?? '', '');
        $this->integerCoder = new IntegerCoder('uint');
        $this->dynamic = empty($this->bits);
    }

    public function encode($data)
    {
        if (!FormatUtil::isZeroPrefixed($data))
            throw new \Exception('bytes param must start with 0x');

        $data = FormatUtil::stripZero($data);
        $bytesLen = strlen(hex2bin($data));

        if (!empty($this->bits) && $this->bits !== $bytesLen) {
            if ($bytesLen < $this->bits)
                $data .= str_repeat('00', $this->bits - $bytesLen);
            else
                throw new \Exception('length not match');
        }

        $data = FormatUtil::stripZero(HexStream::alignHex($data, true));

        if (empty($this->bits))
            $data = FormatUtil::stripZero($this->integerCoder->encode($bytesLen)).$data;

        return FormatUtil::zeroPrefix($data);
    }

    public function decode(HexStream $data)
    {
        $length = $this->getBits() ?? (int)$this->integerCoder->decode($data)->toString();

        $bytesHex = $data->read($length * 2, true);

        return FormatUtil::zeroPrefix($bytesHex);
    }
}