<?php

use Redbox\Validation\ValidationContext;
use Redbox\Validation\Validator;

test('ValidationContext::fails() should be true and ValidationContext::fails() to be false if a test fails.', function() {
    $target = ['foo' => ''];

    $validator = new Validator($target);
    $context  = new ValidationContext('foo', fn() => false);
    $context->run(
        key:'foo',
        value:'bar',
        target: $target,
        validator: $validator
    );

    expect($context->fails())
        ->toBeTruthy()
        ->and($context->passes())->toBeFalsy();
});

test('ValidationContext::fails() should be false and ValidationContext::fails() to be true if a test is successful.', function() {
    $target = ['foo' => ''];

    $validator = new Validator($target);
    $context  = new ValidationContext('foo', fn() => true);
    $context->run(
        key:'foo',
        value:'bar',
        target: $target,
        validator: $validator
    );

    expect($context->passes())
        ->toBeTruthy()
        ->and($context->fails())->toBeFalsy();
});