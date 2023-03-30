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

use Redbox\Validation\Validator;

$validator = new Validator([
    'foo' => 'The quick brown fox jumps over the lazy dog'
]);

$data = $validator->validate([
    'foo' => 'string'
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
    echo "Validation failed\n";
} else {
    echo "Validation passed\n";
}
