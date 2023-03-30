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

namespace Redbox\Validation\Tests\Feature\TypeDefinitions;

use Redbox\Validation\Validator;
use stdClass;

dataset(
    'other_types_then_array',
    [
    null,
    "string",
    1,
    2.0,
    new stdClass(),
    function () {
    },
    true,
    // Resource how ?
    ]
);

test(
    'An array should pass the test.',
    function () {

        $validator = new Validator(
            [
            'field' => [],
            ]
        );

        $validator->validate(
            [
            'field' => 'array'
            ]
        );

        $errors = $validator->errors();
        expect(count($errors))->toEqual(0);
    }
);


test(
    'Other types then array should fail',
    function (mixed $type = null) {
        $validator = new Validator(
            [
            'field' => $type,
            ]
        );

        $validator->validate(
            [
            'field' => 'array'
            ]
        );

        expect($validator->passes())->toBeFalsy()
            ->and($validator->fails())->toBeTruthy();

        $errors = $validator->errors();
        expect($errors['field'])->toEqual("Field field is not of type array.")
            ->and(count($errors))->toEqual(1);
    }
)->with('other_types_then_array');
