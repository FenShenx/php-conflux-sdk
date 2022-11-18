<?php

namespace Fenshenx\PhpConfluxSdk\Contract\Coder;

use Fenshenx\PhpConfluxSdk\Contract\HexStream;
use Fenshenx\PhpConfluxSdk\Utils\FormatUtil;
use Fenshenx\PhpConfluxSdk\Utils\SignUtil;

class AddressCoder implements ICoder
{
    use CoderTrait;

    public function __construct(
        private string $type,
        private int|null $networkId = null
    )
    {
        if ($this->type !== 'address')
            throw new \Exception('Type is not address');
    }

    public function encode($data)
    {
        return HexStream::alignHex(SignUtil::confluxAddress2Address($data));
    }

    public function decode(HexStream $data)
    {
        var_dump($data);
        $hexAddress = $data->read(40);
        var_dump($hexAddress);

        $isCfxAddress = str_starts_with($hexAddress, '1') || str_starts_with($hexAddress, '0') || str_starts_with($hexAddress, '8');

        return ($isCfxAddress && !empty($this->networkId)) ?
            SignUtil::address2ConfluxAddress($hexAddress, $this->networkId)
            :
            FormatUtil::zeroPrefix($hexAddress);
    }
}