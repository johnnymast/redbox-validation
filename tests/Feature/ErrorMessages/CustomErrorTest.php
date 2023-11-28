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

namespace Redbox\Validation\Tests\Feature\ErrorMessages;

use Redbox\Validation\ValidationContext;
use Redbox\Validation\Validator;

test(
    'Custom error message work with predefined types.',
    function () {
        $data = [
            'foo' => 'Foo is a string so the test should fail.'
        ];

        $validator = new Validator($data);
        $validator->validate(
            [
                'foo' => 'int'
            ],
            [
                'foo' => 'This is my custom error message for field foo.'
            ]
        );

        $actual = $validator->fails();
        expect($actual)->toBeTrue();

        $actual = $validator->passes();
        expect($actual)->toBeFalse();

        $errors = $validator->errors();
        expect($errors)->toHaveKey('foo', 'This is my custom error message for field foo.');
    }
);

test(
    'Custom error message work with closures.',
    function () {
        $data = [
            'foo' => 'Foo is a string so the test should fail.'
        ];

        $validator = new Validator($data);
        $validator->validate(
            [
                'foo' => function (ValidationContext $context): bool {
                    return ($context->keyExists() && $context->getValue() === 'baz')
                        or $context->addError(
                            $context->hasCustomErrorMessage() ? $context->getsCustomErrorMessage(
                            ) : "Field {$context->getKey()} does not equal 'baz'."
                        );
                }
            ],
            [
                'foo' => 'This is my custom error message for field foo.'
            ]
        );

        $actual = $validator->fails();
        expect($actual)->toBeTrue();

        $actual = $validator->passes();
        expect($actual)->toBeFalse();

        $errors = $validator->errors();
        expect($errors)->toHaveKey('foo', 'This is my custom error message for field foo.');
    }
);


test(
    'Errors messages should fall back to default error message if no custom message has been set.',
    function () {
        $data = [
            'drink' => 1,
        ];


        $validator = new Validator($data);
        $validator->validate(
            [
                'foo' => 'string'
            ]
        );

        $actual = $validator->fails();
        expect($actual)->toBeTrue();

        $actual = $validator->passes();
        expect($actual)->toBeFalse();

        $errors = $validator->errors();
        expect($errors)->toHaveKey('foo', 'Field foo is not of type string.');
    }
);


test(
    'Errors messages from closures fall back to default error message if no custom message has been set..',
    function () {
        $data = [
            'foo' => 'Foo is a string so the test should fail.'
        ];

        $validator = new Validator($data);
        $validator->validate(
            [
                'foo' => function (ValidationContext $context): bool {
                    return ($context->keyExists() && $context->getValue() === 'baz')
                        or $context->addError(
                            $context->hasCustomErrorMessage() ? $context->getsCustomErrorMessage(
                            ) : "Field {$context->getKey()} does not equal 'baz'."
                        );
                }
            ]
        );

        $actual = $validator->fails();
        expect($actual)->toBeTrue();

        $actual = $validator->passes();
        expect($actual)->toBeFalse();

        $errors = $validator->errors();
        expect($errors)->toHaveKey('foo', 'Field foo does not equal \'baz\'.');
    }
);