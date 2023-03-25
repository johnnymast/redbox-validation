<?php

namespace Redbox\Validation\Tests\Unit;

use Redbox\Validation\Contracts\RuleInterface;
use Redbox\Validation\Exceptions\ValidationDefinitionException;
use Redbox\Validation\Validator;
use function PHPUnit\Framework\exactly;

test('Validator::validate() can be called with a string of one single rule', function () {
    $validator = new Validator();

    $validator->validate([
        'foo' => 'bar'
    ]);

    expect($validator->getRules())->toMatchArray([
        'foo' => ['bar']
    ]);
});

test('Validator::validate() can be called with a string of multiple rules', function () {
    $validator = new Validator();

    $validator->validate(['foo' => 'bar|baz']);

    expect($validator->getRules())->toMatchArray([
        'foo' => ['bar', 'baz']
    ]);
});

test('Validator::validate() can be called with an array of rules', function () {
    $validator = new Validator();

    $validator->validate(['foo' => ['bar', 'baz', 'qux']]);

    expect($validator->getRules())->toMatchArray([
        'foo' => ['bar', 'baz', 'qux']
    ]);
});

test('Validator::validate() can be called with an array of rules classes or rule names', function () {
    $validator = new Validator();

    $validator->validate(['foo' => ['bar', 'baz', 'qux']]);

    expect($validator->getRules())->toMatchArray([
        'foo' => ['bar', 'baz', 'qux']
    ]);
});

test('Validator::validate() rule can be one closure.', function () {

    $closure = function (RuleInterface $rule) {};

    $validator = new Validator();
    $validator->validate(['foo' => $closure]);

    expect($validator->getRules())->toMatchArray([
        'foo' => [$closure]
    ]);
});

test("Validator::validate() rules can be one closure when passing an array of rules.", function () {
    $closureA = function (RuleInterface $rule) {};
    $closureB = function (RuleInterface $rule) {};

    $validator = new Validator();
    $validator->validate(['foo' => [$closureA, $closureB]]);

    expect($validator->getRules())->toMatchArray([
        'foo' => [$closureA, $closureB]
    ]);
});

test("Validator::validate() will throw an exception at unknown rule type.", function () {

    $validator = new Validator();
    $float = 1.0;

    expect(fn() => $validator->validate(["foo" => $float]))
        ->toThrow(ValidationDefinitionException::class, "Unknown validation rule type.");
});
