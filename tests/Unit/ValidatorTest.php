<?php

/**
 * This file is part of the Redbox-validator package.
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Redbox\Validation\Tests\Unit;

use Redbox\Validation\Exceptions\ValidationDefinitionException;
use Redbox\Validation\ValidationContext;
use Redbox\Validation\Validator;

beforeEach(function () {
    $this->validator = new Validator([
        'foo' => false,
    ]);
    $this->validator->defineCustomTypes([
        \Redbox\Validation\Tests\Types\TestDefinitions::class
    ]);
});

test('Validator::validate() can be called with a string of one single rule', function () {

    $this->validator->validate([
        'foo' => 'bar'
    ]);

    expect($this->validator->getRules())->toMatchArray([
        'foo' => ['bar']
    ]);
});

test('Validator::validate() can be called with a string of multiple rules', function () {

    $this->validator->validate(['foo' => 'bar|baz']);

    expect($this->validator->getRules())->toMatchArray([
        'foo' => ['bar', 'baz']
    ]);
});

test('Validator::validate() can be called with an array of rules', function () {

    $this->validator->validate(['foo' => ['bar', 'baz', 'qux']]);

    expect($this->validator->getRules())->toMatchArray([
        'foo' => ['bar', 'baz', 'qux']
    ]);
});

test('Validator::validate() can be called with an array of rules classes or rule names', function () {

    $this->validator->validate(['foo' => ['bar', 'baz', 'qux']]);

    expect($this->validator->getRules())->toMatchArray([
        'foo' => ['bar', 'baz', 'qux']
    ]);
});

test('Validator::validate() rule can be one closure.', function () {

    $closure = fn(ValidationContext $context) => true;

    $this->validator->validate(['foo' => $closure]);

    expect($this->validator->getRules())->toMatchArray([
        'foo' => [$closure]
    ]);
});

test("Validator::validate() rules can be one closure when passing an array of rules.", function () {
    $closureA = fn(ValidationContext $context) => true;
    $closureB = fn(ValidationContext $context) => true;

    $this->validator->validate(['foo' => [$closureA, $closureB]]);

    expect($this->validator->getRules())->toMatchArray([
        'foo' => [$closureA, $closureB]
    ]);
});

test("Validation::validate() will execute single closures you pass it.", function () {

    $closure = fn(ValidationContext $context) => false;

    $this->validator->validate([
        'foo' => $closure
    ]);

    expect($this->validator->fails())->toBeTruthy()
        ->and($this->validator->passes())->toBeFalsy();


    $closure = fn(ValidationContext $context) => true;
    $validator = new Validator(['foo' => false]);
    $validator->validate(['foo' => $closure]);

    expect($validator->passes())->toBeTruthy()
        ->and($validator->fails())->toBeFalsy();
});

test("Validation::validate() will execute multiple closures you pass it.", function () {

    $closureA = fn(ValidationContext $context) => false;
    $closureB = fn(ValidationContext $context) => true;

    $this->validator->validate([
        'foo' => [$closureA, $closureB]
    ]);

    expect($this->validator->fails())->toBeTruthy()
        ->and($this->validator->passes())->toBeFalsy();


    $closureA = fn(ValidationContext $context) => true;
    $closureB = fn(ValidationContext $context) => true;

    $validator = new Validator(['foo' => false]);
    $validator->validate(['foo' => [$closureA, $closureB]]);

    expect($validator->fails())->toBeFalsy()
        ->and($validator->passes())->toBeTruthy();

});

test("Validator::validate() will throw an exception at unknown rule type.", function () {

    $float = 1.0;

    expect(fn() => $this->validator->validate(["foo" => $float]))
        ->toThrow(ValidationDefinitionException::class, "Unknown validation rule type.");
});


test("Validation::hasErrors() if there are known errors.", function () {

    $validator = new Validator([
        'foo' => '',
    ]);

    $validator->validate([
        'foo' => 'boolean'
    ]);

    expect($validator->fails())->toBeTruthy()
        ->and($validator->passes())->toBeFalsy();

    $errors = $validator->errors();

    expect($validator->hasErrors())->toBeTrue()
        ->and($errors['foo'])->toEqual("Field foo is not of type boolean.")
        ->and(count($errors))->toEqual(1);
});