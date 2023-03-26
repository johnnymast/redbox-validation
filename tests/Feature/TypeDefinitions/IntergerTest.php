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

use Redbox\Validation\Validator;

dataset('other_types_then_integer', [
    null,
    true,
    "string",
    2.0,
    [],
    new stdClass(),
    function () {
    },
    // Resource how ?
]);

test('value 10 should be considered a integer', function () {

    $validator = new Validator([
        'field' => 10,
    ]);

    $validator->validate([
        'field' => 'integer'
    ]);

    $errors = $validator->errors();
    expect(count($errors))->toEqual(0);
});

test('[ALIAS] value 10 should be considered a int', function () {

    $validator = new Validator([
        'field' => 10,
    ]);

    $validator->validate([
        'field' => 'integer'
    ]);

    $errors = $validator->errors();
    expect(count($errors))->toEqual(0);
});

test('Other types then integers should fail', function (mixed $type = null) {
    $validator = new Validator([
        'field' => $type,
    ]);

    $validator->validate([
        'field' => 'integer'
    ]);

    expect($validator->passes())->toBeFalsy()
        ->and($validator->fails())->toBeTruthy();


    $errors = $validator->errors();
    expect($errors['field'])->toEqual("Field field is not of type integer.")
        ->and(count($errors))->toEqual(1);

})->with('other_types_then_integer');