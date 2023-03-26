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

require __DIR__ . '/autoload.php';

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
