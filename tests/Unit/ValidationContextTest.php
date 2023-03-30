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

use Redbox\Validation\ValidationContext;
use Redbox\Validation\Validator;

test(
    'ValidationContext::fails() should be true and ValidationContext::fails() to be false if a test fails.',
    function () {
        $target = ['foo' => ''];

        $validator = new Validator($target);

        $context = new ValidationContext(
            'foo',
            function (ValidationContext $context) {
                return false;
            }
        );

        $context->run(
            key: 'foo',
            value: 'bar',
            target: $target,
            validator: $validator
        );

        expect($context->fails())
            ->toBeTruthy()
            ->and($context->passes())->toBeFalsy();
    }
);

test(
    'ValidationContext::fails() should be false and ValidationContext::fails() to be true if a test is successful.',
    function () {

        $target = ['foo' => ''];

        $validator = new Validator($target);
        $context = new ValidationContext('foo', fn() => true);
        $context->run(
            key: 'foo',
            value: 'bar',
            target: $target,
            validator: $validator
        );

        expect($context->passes())
            ->toBeTruthy()
            ->and($context->fails())->toBeFalsy();
    }
);
