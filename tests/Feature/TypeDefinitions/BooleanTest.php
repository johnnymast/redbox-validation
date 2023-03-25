<?php


use Redbox\Validation\Exceptions\ValidationException;
use Redbox\Validation\Validator;

test('value 1 should not be considered a boolean', function () {
    $validator = new Validator([
        'field' => 1,
    ]);

    expect(
        fn() => $validator->validate([
            'field' => 'boolean'
        ])
    )->toThrow(ValidationException::class, "Validator failed");

    $errors = $validator->getErrors();
    expect(count($errors))->toEqual(1);
});

test('value \'true\' should not be considered a boolean', function () {
    $validator = new Validator([
        'field' => 'true',
    ]);

    expect(
        fn() => $validator->validate([
            'field' => 'boolean'
        ])
    )->toThrow(ValidationException::class, "Validator failed");

    $errors = $validator->getErrors();
    expect(count($errors))->toEqual(1);
});

test('value true should be considered a boolean', function () {
    $validator = new Validator([
        'field' => true,
    ]);

    $validator->validate([
        'field' => 'boolean'
    ]);

    $errors = $validator->getErrors();
    expect(count($errors))->toEqual(0);
});

test('value 0 should not be considered a boolean', function () {
    $validator = new Validator([
        'field' => 0,
    ]);

    expect(
        fn() => $validator->validate([
            'field' => 'boolean'
        ])
    )->toThrow(ValidationException::class, "Validator failed");

    $errors = $validator->getErrors();
    expect(count($errors))->toEqual(1);
});

test('value \'false\' should not be considered a boolean', function () {
    $validator = new Validator([
        'field' => 'false',
    ]);

    expect(
        fn() => $validator->validate([
            'field' => 'boolean'
        ])
    )->toThrow(ValidationException::class, "Validator failed");

    $errors = $validator->getErrors();
    expect(count($errors))->toEqual(1);
});

test('value false should be considered a boolean', function () {
    $validator = new Validator([
        'field' => false,
    ]);

    $validator->validate([
        'field' => 'boolean'
    ]);

    $errors = $validator->getErrors();
    expect(count($errors))->toEqual(0);
});