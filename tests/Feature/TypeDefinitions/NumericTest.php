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
    'other_types_then_numeric',
    [
        null,
        "string",
        new stdClass(),
        function () {
        },
        true,
        [],
        // Resource how ?
    ]
);

dataset('valid_numeric_notations', [
    "42",
    1234, // decimal number
    0123, // octal number (equivalent to 83 decimal)
    0o123, // octal number (as of PHP 8.1.0)
    0x1A, // hexadecimal number (equivalent to 26 decimal)
    0b11111111, // binary number (equivalent to 255 decimal)
    1_234_567, // decimal number (as of PHP 7.4.0)
    '1337e0', // exponential notation
    '02471' // leading zero is allowed

]);

test(
    'An number should pass the test.',
    function () {

        $validator = new Validator(
            [
                'field' => 25,
            ]
        );

        $validator->validate(
            [
                'field' => 'numeric'
            ]
        );

        $errors = $validator->errors();
        expect(count($errors))->toEqual(0);
    }
);


test(
    'All number notations should pass the test.',
    function ($numeric) {

        $validator = new Validator(
            [
                'field' => $numeric,
            ]
        );

        $validator->validate(
            [
                'field' => 'numeric'
            ]
        );

        $errors = $validator->errors();
        expect(count($errors))->toEqual(0);
    }
)->with('valid_numeric_notations');

test(
    'Other types then numbers should fail',
    function (mixed $type = null) {
        $validator = new Validator(
            [
                'field' => $type,
            ]
        );

        $validator->validate(
            [
                'field' => 'numeric'
            ]
        );

        expect($validator->passes())->toBeFalsy()
            ->and($validator->fails())->toBeTruthy();

        $errors = $validator->errors();
        expect($errors['field'])->toEqual("Field field is not numeric.")
            ->and(count($errors))->toEqual(1);
    }
)->with('other_types_then_numeric');
