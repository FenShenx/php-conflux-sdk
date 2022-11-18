<?php

namespace Fenshenx\PhpConfluxSdk\Contract;

use Fenshenx\PhpConfluxSdk\Utils\EncodeUtil;
use Fenshenx\PhpConfluxSdk\Utils\FormatUtil;

class HexStream
{
    private string $hex;

    private int $index;

    private int $wordCharts = EncodeUtil::WORD_CHARS;

    public function __construct(
        string $hex
    )
    {
        $this->hex = FormatUtil::zeroPrefix($hex);
        $this->index = 2;   //without 0x
    }

    public function getCurrentIndex()
    {
        return $this->index;
    }

    public function eof()
    {
        return $this->index >= strlen($this->hex);
    }

    public function read(int $length, bool $alignLeft = false)
    {
        if ($length <= 0)
            throw new \Exception('invalid length:'.$length);

        $size = ceil((float)$length / (float)$this->wordCharts) * $this->wordCharts;

        $hex = $alignLeft ?
            substr($this->hex, $this->index, $length)
            :
            substr($this->hex, $this->index + ($size - $length), $length);

        if (strlen($hex) !== $length)
            throw new \Exception('length not match');

        $this->index += $size;

        return $hex;
    }

    public static function alignHex($hex, $alignLeft = false) {

        $hex = FormatUtil::stripZero($hex);
        $hexBin = hex2bin($hex);
        $count = EncodeUtil::WORD_BYTES - (strlen($hexBin) % EncodeUtil::WORD_BYTES);

        if (0 < $count && $count < EncodeUtil::WORD_BYTES) {

            $buf = str_repeat('00', $count);
            $hex = $alignLeft ? ($hex.$buf) : ($buf.$hex);
        }

        return FormatUtil::zeroPrefix($hex);
    }
}