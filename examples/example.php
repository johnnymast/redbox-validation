<?php

use Redbox\Validation\Contracts\RuleInterface;
use Redbox\Validation\Validator;

require __DIR__.'/../vendor/autoload.php';



$instance = (new Redbox\Validation\Validator())
    ->validate('test', 'boolean');


$closure = function (RuleInterface $rule) {};

$validator = new Validator();
$validator->validate('foo', $closure);

print_r($validator->getRules());
//    expect($validator->getRules())->toMatchArray([
//        'foo' => [$closure]
//    ]);
exit;