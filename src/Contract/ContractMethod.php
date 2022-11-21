<?php

namespace Fenshenx\PhpConfluxSdk\Contract;

use Fenshenx\PhpConfluxSdk\Contract\Coder\CoderFactory;
use Fenshenx\PhpConfluxSdk\Contract\Coder\ICoder;
use Fenshenx\PhpConfluxSdk\Contract\Coder\IntegerCoder;
use Fenshenx\PhpConfluxSdk\Utils\EncodeUtil;
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
        $this->signature = substr(Keccak::hash($this->type, 256), 0,8);
    }

    public function encodeInputs(array $inputs)
    {
        $data = $this->signature;

        if (!empty($inputs)) {

            $data .= self::encode($this->inputsCoders, $inputs);
        }

        return FormatUtil::zeroPrefix($data);
    }

    /**
     * @param ICoder[] $coders
     * @param array $data
     * @return string
     */
    public static function encode(array $coders, array $inputs)
    {
        $integerCoder = new IntegerCoder('uint');
        $inputKeys = array_keys($inputs);
        if ($inputKeys != range(0, count($inputs)-1)) {
            //inputs is key => value array
            //PHP8.0 Named Arguments https://www.php.net/manual/en/functions.arguments.php#functions.named-arguments
            $inputCoderKeysIndex = array_flip(array_keys($coders));

            $newInputs = [];
            foreach ($inputs as $k => $v) {

                if (!isset($inputCoderKeysIndex[$k]))
                    throw new \Exception("Undefined param".$k);

                $newInputs[$inputCoderKeysIndex[$k]] = $v;
            }

            //resort inputs array
            ksort($newInputs);
            $inputs = $newInputs;
        }

        //encode params
        $staticList = [];
        $dynamicList = [];
        $offset = 0;

        foreach (array_values($coders) as $k => $coder) {

            if (!isset($inputs[$k]))
                break;

            $value = $inputs[$k];
            $buffer = $coder->encode($value);

            if ($coder->getDynamic()) {

                $offset += EncodeUtil::WORD_BYTES;
                $staticList[] = new BigInteger(count($dynamicList));  // push index of dynamic to static
                $dynamicList[] = $buffer;
            } else {

                $offset += strlen(hex2bin(FormatUtil::stripZero($buffer)));
                $staticList[] = $buffer;
            }
        }

        foreach ($staticList as $k => $v) {
            if ($v instanceof BigInteger) {
                $staticList[$k] = $integerCoder->encode($offset);
                $offset += strlen(hex2bin(FormatUtil::stripZero($dynamicList[(int)$v->toString()])));
            }
        }

        $encoded = implode(array_map(function ($hex) {
            return FormatUtil::stripZero($hex);
        }, array_merge($staticList, $dynamicList)));

        return $encoded;
    }

    public function decodeOutputs($outputs)
    {
        $integerCoder = new IntegerCoder('uint');
        $hex = new HexStream($outputs);
        $startIndex = $hex->getCurrentIndex();

        $arr = array_map(function (ICoder $coder) use ($hex, $startIndex, $integerCoder) {
            if ($coder->getDynamic()) {
                $offset = $integerCoder->decode($hex);
                return new Pointer($offset->multiply(new BigInteger(2))->add(new BigInteger($startIndex))->toHex(), 16);
            } else {
                return $coder->decode($hex);
            }
        }, array_values($this->outputsCoders));

        foreach (array_values($this->outputsCoders) as $k => $v) {
            if ($arr[$k] instanceof Pointer) {
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