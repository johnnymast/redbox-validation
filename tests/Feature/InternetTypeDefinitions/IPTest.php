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

dataset('valid_ip_addresses', [
    '192.168.0.1',
    '10.0.0.1',
    '172.16.0.1',
    '192.168.1.1',
    '2001:db8:85a3:0:0:8A2E:370:7334',
    '2001:db8:85a3::8A2E:370:7334',
    '2001:db8:85a3:0:0:8A2E:370:7334',
    '2001:db8:85a3::8A2E:370:7334',
    '2001:db8:85a3:0:0:8A2E:370:7334',
    '2001:db8:85a3::8A2E:370:7334',
    '2001:db8:85a3:0:0:8A2E:370:7334',
    '2001:db8:85a3::8A2E:370:7334',
]);

dataset('invalid_ip_addresses', [
    '2001::85a3::8a2e::0370::7334', // invalid
    '2001:0db8:85a3:0000:0000:8a2e:0370:', // invalid
    '2001::85a3::8a2e::0370', // invalid
    '2001:0db8:85a3:0000:0000:8a2e:0370', // invalid
    '2001:85a3:0000:0000:8a2e:0370:7334', // invalid
    '2001:0db8:85a3:0000:0000:8a2e:0370:7334:7334', // invalid
    '192.168.0.1.1', // invalid
    '192.168..1', // invalid
    '192.168.0.', // invalid
    '192.168.-1', // invalid
    '192.168.0', // invalid
]);

it('Validator::validate() should detect valid ip addresses.', function ($ip) {

    $validator = new Validator([
        'ip' => $ip,
    ]);

    $validator->validate([
        'ip' => 'ip'
    ]);

    expect($validator->passes())->toBeTruthy()
        ->and($validator->fails())->toBeFalsy();
})->with('valid_ip_addresses');


it('Validator::validate() should detect invalid ip addresses.', function ($ip) {

    $validator = new Validator([
        'ip' => $ip,
    ]);

    $validator->validate([
        'ip' => 'ip'
    ]);

    expect($validator->passes())->toBeFalsy()
        ->and($validator->fails())->toBeTruthy();
})->with('invalid_ip_addresses');
