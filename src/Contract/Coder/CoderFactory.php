<?php

namespace Fenshenx\PhpConfluxSdk\Contract\Coder;

class CoderFactory
{
    public static function generateCoder($abi) : ICoder
    {
        $type = $abi['type'];
        preg_match('/^(.*)\[([0-9]*)]$/', $type, $arrTypeArr);

        if (empty($arrTypeArr)) {

            if ($type === 'tuple')
                return new TupleCoder($type);

            if ($type === 'address') {

                $networkId  = $abi['networkId'] ?? null;
                if (empty($networkId))
                    $networkId = null;

                return new AddressCoder($type, $networkId);
            }

            if (preg_match('/^(int|uint)([0-9]*)$/', $type))
                return new IntegerCoder($type);

            if ($type === 'string')
                return new StringCoder($type);

            if (preg_match('/^bytes([0-9]*)$/', $type))
                return new ByteCoder($type);

            if ($type === 'bool')
                return new BoolCoder($type);

            if ($type === '')
                return new NullCoder();

            throw new \Exception('Unknown type');
        } else {

            return new ArrayCoder($type);
        }
    }
}