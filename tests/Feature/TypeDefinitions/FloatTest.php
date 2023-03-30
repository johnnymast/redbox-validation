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
    'other_types_then_float',
    [
        null,
        "string",
        1,
        [],
        function () {
        },
        new stdClass(),
        true,
    ]
);


test(
    'An float should pass the test.',
    function () {

        $validator = new Validator(
            [
                'field' => 1.0,
            ]
        );

        $validator->validate(
            [
                'field' => 'float'
            ]
        );

        $errors = $validator->errors();
        expect(count($errors))->toEqual(0);
    }
);

test(
    'An double should pass the test.',
    function () {

        $validator = new Validator(
            [
                'field' => 1.0,
            ]
        );

        $validator->validate(
            [
                'field' => 'double'
            ]
        );

        $errors = $validator->errors();
        expect(count($errors))->toEqual(0);
    }
);

test(
    'Other types then float should fail when validating type float',
    function (mixed $type = null) {
        $validator = new Validator(
            [
                'field' => $type,
            ]
        );

        $validator->validate(
            [
                'field' => 'float'
            ]
        );

        expect($validator->passes())->toBeFalsy()
            ->and($validator->fails())->toBeTruthy();

        $errors = $validator->errors();
        expect($errors['field'])->toEqual("Field field is not of type float.")
            ->and(count($errors))->toEqual(1);
    }
)->with('other_types_then_float');


test(
    'Other types then float should fail when validating type double',
    function (mixed $type = null) {
        $validator = new Validator(
            [
                'field' => $type,
            ]
        );

        $validator->validate(
            [
                'field' => 'double'
            ]
        );

        expect($validator->passes())->toBeFalsy()
            ->and($validator->fails())->toBeTruthy();

        $errors = $validator->errors();
        expect($errors['field'])->toEqual("Field field is not of type float.")
            ->and(count($errors))->toEqual(1);
    }
)->with('other_types_then_float');