<?php

use Redbox\Validation\Contracts\RuleInterface;
use Redbox\Validation\Exceptions\ValidationException;
use Redbox\Validation\ValidationContext;
use Redbox\Validation\Validator;

require __DIR__ . '/../vendor/autoload.php';


try {

    $closure =  function(ValidationContext $validator): bool { return true; };
    $validator = new Validator(['foo' =>'']);
    $data = $validator->validate([
        'food' => $closure
    ]);

    // Success
    echo "OI\n";
    var_dump($validator->passes());

} catch (ValidationException $e) {

    var_dump($validator->passes());
    print_r($validator->getErrors());
}
//
//$instance->validate("foo", (float)1.0);