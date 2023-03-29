<?php

/**
 * This file is part of the Redbox-validator package.
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 * PHP version 8.1
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use Redbox\Validation\Validator;

dataset('other_types_then_string', [
    null,
    true,
    1,
    2.0,
    [],
    new stdClass(),
    function () {
    },
    // Resource how ?
]);

test('value \'test\' should be considered a string', function () {

    $validator = new Validator([
        'field' => 'test',
    ]);

    $validator->validate([
        'field' => 'string'
    ]);

    $errors = $validator->errors();
    expect(count($errors))->toEqual(0);
});

test('Other types then strings should fail', function (mixed $type = null) {
    $validator = new Validator([
        'field' => $type,
    ]);

    $this->setName("other types then strings should fail testing with type " . get_debug_type($type));

    $validator->validate([
        'field' => 'string'
    ]);

    expect($validator->passes())->toBeFalsy()
        ->and($validator->fails())->toBeTruthy();

    $errors = $validator->errors();
    expect($errors['field'])->toEqual("Field field is not of type string.")
        ->and(count($errors))->toEqual(1);
})->with('other_types_then_string');
