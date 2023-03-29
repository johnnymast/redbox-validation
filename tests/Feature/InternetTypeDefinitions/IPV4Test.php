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

use Redbox\Validation\Validator;

dataset('invalid_ipv4_addresses', [
    '300.168.0.1', // invalid
    '192.300.0.1', // invalid
    '192.168.300.1', // invalid
    '192.168.0.300', // invalid
    '192.168.0.256', // invalid
    '192.168.0.1.1', // invalid
    '192.168..1', // invalid
    '192.168.0.', // invalid
    '192.168.-1', // invalid
    '192.168.0', // invalid
]);

dataset('valid_ip4_addresses', [
    '192.168.0.1',
    '10.0.0.1',
    '172.16.0.1',
    '192.168.1.1',
]);

it('Validator::validate() should detect valid ipv4 addresses.', function ($ip) {

    $validator = new Validator([
        'ip' => $ip,
    ]);

    $validator->validate([
        'ip' => 'ipv4'

    ]);

    expect($validator->passes())->toBeTruthy()
        ->and($validator->fails())->toBeFalsy();
})->with('valid_ip4_addresses');


it('Validator::validate() should detect invalid ipv4 addresses.', function ($ip) {
    $validator = new Validator([
        'ip' => $ip,
    ]);

    $validator->validate([
        'ip' => 'ipv4'

    ]);

    expect($validator->passes())->toBeFalsy()
        ->and($validator->fails())->toBeTruthy();
})->with('invalid_ipv4_addresses');
