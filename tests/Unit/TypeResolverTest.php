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

use Redbox\Validation\Tests\Types\TestDefinitions;
use Redbox\Validation\TypeResolver;
use Redbox\Validation\ValidationContext;

test(
    'Type definitions should be automatically detected',
    function () {

        $resolved = TypeResolver::resolveTypes([TestDefinitions::class]);
        expect($resolved)->toHaveKey('foo')
            ->toHaveKey('bar')
            ->toHaveKey('baz')
            ->toHaveKey('qux');
    }
);

test(
    'TypeResolver::isValidClosure() should return false if the closure has no parameters.',
    function () {
        $closure = function (): bool {
            return true;
        };

        expect(TypeResolver::isValidClosure($closure))->toBeFalsy();
    }
);

test(
    'TypeResolver::isValidClosure() should return false if the first parameter is not ValidationContext.',
    function () {
        $closure = function (string $error): bool {
            return true;
        };

        expect(TypeResolver::isValidClosure($closure))->toBeFalsy();
    }
);

test(
    'TypeResolver::isValidClosure() should return true if closure has multiple parameters.',
    function () {
        $closure = function (ValidationContext $context, string $other = ''): bool {
            return true;
        };

        expect(TypeResolver::isValidClosure($closure))->toBeTruthy();
    }
);

test(
    'TypeResolver::isValidClosure() should return false if closure does not return bool.',
    function () {
        $closure = function (ValidationContext $context): string {
            return 'mystring';
        };

        expect(TypeResolver::isValidClosure($closure))->toBeFalsy();
    }
);
