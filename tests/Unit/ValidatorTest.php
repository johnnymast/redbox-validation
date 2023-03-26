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


namespace Redbox\Validation\Tests\Unit;

use Redbox\Validation\Exceptions\ValidationDefinitionException;
use Redbox\Validation\Exceptions\ValidationException;
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

    expect(
        fn() => $this->validator->validate([
            'foo' => $closure
        ])
    )->toThrow(ValidationException::class, "Validator failed");

    expect($this->validator->didPass())->toBeFalse();

    $closure = fn(ValidationContext $context) => true;
    $validator = new Validator(['foo' => false]);
    $validator->validate(['foo' => $closure]);

    expect($validator->didPass())->toBeTrue();
});

test("Validation::validate() will execute multiple closures you pass it.", function () {

    $closureA = fn(ValidationContext $context) => false;
    $closureB = fn(ValidationContext $context) => true;

    expect(
        fn() => $this->validator->validate([
            'foo' => [$closureA, $closureB]
        ])
    )->toThrow(ValidationException::class, "Validator failed");

    expect($this->validator->didPass())->toBeFalse();

    $closureA = fn(ValidationContext $context) => true;
    $closureB = fn(ValidationContext $context) => true;

    $validator = new Validator(['foo' => false]);
    $validator->validate(['foo' => [$closureA, $closureB]]);

    expect($validator->didPass())->toBeTrue();
});

test("Validator::validate() will throw an exception at unknown rule type.", function () {

    $float = 1.0;

    expect(fn() => $this->validator->validate(["foo" => $float]))
        ->toThrow(ValidationDefinitionException::class, "Unknown validation rule type.");
});


