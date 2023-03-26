<?php

/**
 * This file is part of the Redbox-validator package.
 *
 * (c) Johnny Mast <mastjohnny@gmail.com
 *
 * PHP version 8.1
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Redbox\Validation\Exceptions\ValidationException;
use Redbox\Validation\Tests\Types\TestDefinitions;
use Redbox\Validation\Validator;

beforeEach(function () {
    $validator = new Validator([
        'field' => false,
    ]);
    $validator->defineCustomTypes([
        TestDefinitions::class
    ]);
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

test('value true should be considered a boolean', function () {

    $validator = new Validator([
        'field' => false,
    ]);

    $validator->validate([
        'field' => 'boolean'
    ]);

    $errors = $validator->getErrors();
    expect(count($errors))->toEqual(0);
});

test('running the boolean type check on a non-existing key in the target array should fail.', function () {

    $validator = new Validator([
        'field' => false,
    ]);

    expect(
        fn() => $validator->validate([
            'nonexisting' => 'boolean'
        ])
    )->toThrow(ValidationException::class, "Validator failed");

    $errors = $validator->getErrors();
    expect(count($errors))->toEqual(1);
});

test('value 1 should not be considered a boolean', function () {

    $validator = new Validator([
        'myfield' => 1,
    ]);

    expect(
        fn() => $validator->validate([
            'myfield' => 'boolean'
        ])
    )->toThrow(ValidationException::class, "Validator failed");

    $errors = $validator->getErrors();
    expect($errors['myfield'])->toEqual("Field myfield is not of type boolean.");
    expect(count($errors))->toEqual(1);
});

test('value \'true\' should not be considered a boolean', function () {

    $validator = new Validator([
        'myfield' => 'true',
    ]);

    expect(
        fn() => $validator->validate([
            'myfield' => 'boolean'
        ])
    )->toThrow(ValidationException::class, "Validator failed");

    $errors = $validator->getErrors();
    expect($errors['myfield'])->toEqual("Field myfield is not of type boolean.");
    expect(count($errors))->toEqual(1);
});

test('value 0 should not be considered a boolean', function () {

    $validator = new Validator([
        'field' => 0,
    ]);

    expect(
        fn() => $validator->validate([
            'myfield' => 'boolean'
        ])
    )->toThrow(ValidationException::class, "Validator failed");

    $errors = $validator->getErrors();
    expect($errors['myfield'])->toEqual("Field myfield is not of type boolean.");
    expect(count($errors))->toEqual(1);
});

test('value \'false\' should not be considered a boolean', function () {

    $validator = new Validator([
        'myfield' => 'false',
    ]);

    expect(
        fn() => $validator->validate([
            'myfield' => 'boolean'
        ])
    )->toThrow(ValidationException::class, "Validator failed");

    $errors = $validator->getErrors();
    expect($errors['myfield'])->toEqual("Field myfield is not of type boolean.");
    expect(count($errors))->toEqual(1);
});
