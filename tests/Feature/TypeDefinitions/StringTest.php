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
use Redbox\Validation\Validator;

dataset('types', [
    null,
    true,
    1,
    2.0,
    [],
    new stdClass(),
    fn() => true,
    // Resource how ?
]);

test('value \'test\' should be considered a string', function () {

    $validator = new Validator([
        'field' => 'test',
    ]);

    $validator->validate([
        'field' => 'string'
    ]);

    $errors = $validator->getErrors();
    expect(count($errors))->toEqual(0);
});

test('other types then strings should fail testing with type', function (mixed $type = null) {
    $validator = new Validator([
        'field' => $type,
    ]);

    $this->setName("other types then strings should fail testing with type ".get_debug_type($type));

    expect(
        fn() => $validator->validate([
            'field' => 'string'
        ])
    )->toThrow(ValidationException::class, "Validator failed");


    $errors = $validator->getErrors();
    expect(count($errors))->toEqual(1);

})->with('types');