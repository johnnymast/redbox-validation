# Redbox-valiation

Redbox-valiation is a simple to use validation class. The implementation is based on Laravel's (but no a rewrite of)
validation package but has no external when used in your project.

[![Packagist](https://img.shields.io/packagist/v/redbox/validation.svg)](https://packagist.org/packages/redbox/validation)
[![Unit Tests](https://github.com/johnnymast/redbox-validation/actions/workflows/Tests.yml/badge.svg)](https://github.com/johnnymast/redbox-validation/actions/workflows/Tests.yml)
[![PhpCS](https://github.com/johnnymast/redbox-validation/actions/workflows/Phpcs.yaml/badge.svg)](https://github.com/johnnymast/redbox-validation/actions/workflows/Phpcs.yaml)
[![PhpCS](https://raw.githubusercontent.com/johnnymast/redbox-validation/master/badges/coverage-badge.svg)](https://github.com/johnnymast/redbox-validation/actions/workflows/pest-coverage.yaml)

## Installation

```bash
$ composer require redbox/validation
```

## Usage

The package is flexible to use with an easy syntax.

## Basic Usage
```php 
use Redbox\Validation\Validator;

$validator = new Validator([
    'foo' => 'The quick brown fox jumps over the lazy dog'
]);

$data = $validator->validate([
    'food' => 'string'
]);

/**
 * Validator::passes() is also
 * available.
 */
if ($validator->fails()) {
    /**
     * Handle errors use $validator->errors()
     * to get the errors.
     */
}
```

## Using closures

You can use your own closures to add custom rules 

```php

use Redbox\Validation\ValidationContext;
use Redbox\Validation\Validator;

$validator = new Validator([
    'foo' => 'The quick brown fox jumps over the lazy dog'
]);

$data = $validator->validate([
    /**
     * This will validate field 'foo' equals 'baz' in this case it will not so
     * the validation will fail and an error will be set for field 'foo'.
     */
    'foo' => function (ValidationContext $context): bool {

        return ($context->keyExists() &&  $context->getValue() === 'baz')
            or $context->addError("Field {$context->getKey()} does not equal 'baz'.");
    }
]);

/**
 * Validator::passes() is also
 * available.
 */
if ($validator->fails()) {
    /**
     * Handle errors use $validator->errors()
     * to get the errors.
     */
    print_r($validator->errors());
}
```

## Available Rules

The following validation rules are available with this package.

| Type    | Alias | Description                                         |
|---------|-------|-----------------------------------------------------|
| string  | N/A   | The field under validation must be of type string.  |
| boolean | bool  | The field under validation must be of type boolean. |
| integer | int   | The field under validation must be of type integer. |


## License

The MIT License (MIT)

Copyright (c) 2023 Johnny Mast

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
