# PHP Conflux SDK

## Insatall

```shell
composer require fenshenx/php-conflux-sdk
```

## Using Conflux

- Test Net: https://test.confluxrpc.com  NetworkId:1
- Main Net: https://main.confluxrpc.com  NetworkId:1029

## Transaction

```php
require_once "vendor/autoload.php";

$conflux = new \Fenshenx\PhpConfluxSdk\Conflux("https://test.confluxrpc.com", 1);

$cfx = $conflux->getCfx();

$account = $conflux->getWallet()->addPrivateKey('0x0000000xxxxxxxxx');  //your private key
$options = [
    'from' => $account->getConfluxAddress(),
    'to' => 'cfxtest:aapr2jm67p5myymb51g0caszkred0907eayz84w6v3',
    'value' => \Fenshenx\PhpConfluxSdk\Drip::fromCFX(1)
];

$gasInfo = $cfx->estimateGasAndCollateral($options);
$hash = $cfx->sendTransaction($options);
```

## GetBalance

```php
$balance = $cfx->getBalance('cfxtest:aapr2jm67p5myymb51g0caszkred0907eayz84w6v3');
$balanceDrip = $balance->getDrip(); //string
$balanceDripHex = $balance->getDripHex();
$balanceCfx = $balance->toCFX();
```

## Contract

```php
$account = $conflux->getWallet()->addPrivateKey('0x00000xxxxx');    //your private key

$contractAddress = "cfxtest:acgh0vts2ga63dpwrbtzcgbz9m4x01bpkjwu9sufp4";
$abi = file_get_contents($contractAddress.'.json');
$contract = $conflux->getContract($abi, $contractAddress);

// Call contract 'balanceOf' method
$balance = $contract->balanceOf("cfxtest:aapr2jm67p5myymb51g0caszkred0907eayz84w6v3")->send();

// Send contract 'mint' transaction
$mintTransactionGas = $contract->mint($account->getConfluxAddress(), 100)->estimateGasAndCollateral($account);
$mintTransactionHash = $contract->mint($account->getConfluxAddress(), 100)->sendTransaction($account);
```

`$conflux->getContract` function return a new `Fenshenx\PhpConfluxSdk\Contract\Contract` class

`$contract->xxxxxxxxx()` return a new `Fenshenx\PhpConfluxSdk\Contract\MethodTransaction` class

## Create Account

```php
$account = $conflux->getWallet()->addRandom();
```