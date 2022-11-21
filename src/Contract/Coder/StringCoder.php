<?php

namespace Fenshenx\PhpConfluxSdk\Contract\Coder;

use Fenshenx\PhpConfluxSdk\Contract\HexStream;
use Fenshenx\PhpConfluxSdk\Utils\FormatUtil;

class StringCoder extends ByteCoder
{
    use CoderTrait;

    public function __construct(
        private string $type
    )
    {
        parent::__construct('bytes');

        $this->dynamic = true;
    }

    public function encode($data)
    {
        if (!is_string($data))
            throw new \Exception('value type error, $data must be a string');

        return parent::encode(FormatUtil::zeroPrefix(bin2hex($data)));
    }

    public function decode(HexStream $data)
    {
        $bytes = parent::decode($data);

        return $this->bytes2Str($bytes);
    }

    private function bytes2Str($bytes)
    {
        return hex2bin(FormatUtil::stripZero($bytes));
    }
}