<?php

use Redbox\Validation\Contracts\RuleInterface;
use Redbox\Validation\Exceptions\ValidationException;
use Redbox\Validation\Validator;

require __DIR__ . '/../vendor/autoload.php';


try {
    $validator = new Redbox\Validation\Validator(['test' => true]);
    $data = $validator->validate(['test' => 'boolean']);

    // Success
    print_r($data);

} catch (ValidationException $e) {
    print_r($validator->getErrors());
}
//
//$instance->validate("foo", (float)1.0);