<?php

use Redbox\Validation\Contracts\RuleInterface;
use Redbox\Validation\Exceptions\ValidationException;
use Redbox\Validation\ValidationContext;
use Redbox\Validation\Validator;

require __DIR__ . '/../vendor/autoload.php';


try {
    $closure = function (RuleInterface $rule) {
    };

    $validator = new Validator(['foo' => '']);
    $data = $validator->validate([
        'food' => fn(ValidationContext $context) => false
    ]);

    // Success
    echo "OI";
    var_dump($validator->didPass());

} catch (ValidationException $e) {

    var_dump($validator->didPass());
    print_r($validator->getErrors());
}
//
//$instance->validate("foo", (float)1.0);