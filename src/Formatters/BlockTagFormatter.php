<?php

namespace Fenshenx\PhpConfluxSdk\Formatters;

use Fenshenx\PhpConfluxSdk\Enums\BlockTag;
use Fenshenx\PhpConfluxSdk\Utils\FormatUtil;

class BlockTagFormatter implements IFormatter
{

    public static function format($value)
    {
        if ($value instanceof BlockTag)
            return $value->getCase();

        if (str_starts_with($value, '0x'))
            return $value;

        if (in_array($value, BlockTag::getCases()))
            return $value;

        return FormatUtil::numberToHex($value, true);
    }
}