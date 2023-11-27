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
    'foo' => 'bleep'
]);

$data = $validator->validate(
    [
        'foo' => 'int'
    ],
    [
        'foo' => 'This is my custom error message for field foo.'
    ]
);

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
    print_r($validator->errors());
} else {
    echo "Validation passed\n";
}
