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

dataset(
    'valid_ipv6_addresses',
    [
    '2001:0db8:85a3:0000:0000:8a2e:0370:7334',
    '2001:db8:85a3:0:0:8a2e:370:7334',
    '2001:db8:85a3::8a2e:370:7334',
    '2001:db8:85a3:0:0:8A2E:370:7334',
    '2001:db8:85a3::8A2E:370:7334',
    '2001:db8:85a3:0:0:8A2E:370:7334',
    '2001:db8:85a3::8A2E:370:7334',
    '2001:db8:85a3:0:0:8A2E:370:7334',
    '2001:db8:85a3::8A2E:370:7334',
    '2001:db8:85a3:0:0:8A2E:370:7334',
    '2001:db8:85a3::8A2E:370:7334',
    '2001:db8:85a3:0:0:8A2E:370:7334',
    '2001:db8:85a3::8A2E:370:7334',
    '2001:db8:85a3:0:0:8A2E:370:7334',
    '2001:db8:85a3::8A2E:370:7334',
    '2001:db8:85a3:0:0:8A2E:370:7334',
    '2001:db8:85a3::8A2E:370:7334',
    '2001:db8:85a3:0:0:8A2E:370:7334',
    '2001:db8:85a3::8A2E:370:7334',
    '2001:db8:85a3:0:0:8A2E:370:7334',
    ]
);


dataset(
    'invalid_ipv6_addresses',
    [
    '2001:0db8:85a3:0000:0000:8a2e:0370:7334:', // invalid
    '2001::85a3::8a2e::0370::7334', // invalid
    '2001:0db8:85a3:0000:0000:8a2e:0370:', // invalid
    '2001::85a3::8a2e::0370', // invalid
    '2001:0db8:85a3:0000:0000:8a2e:0370', // invalid
    '2001:85a3:0000:0000:8a2e:0370:7334', // invalid
    '2001:0db8:85a3:0000:0000:8a2e:0370:7334:7334', // invalid
    '2001:0db8:85a3:0000:0000:8a2e:0370:', // invalid
    '2001:0db8:85a3:0000:0000:8a2e:0370:7334:', // invalid
    '2001:0db8:85a3:0000:0000:8a2e:0370:7334:7334', // invalid
    '2001:0db8:85a3:0000:0000:8a2e:0370:7334:7334:7334', // invalid
    '2001:0db8:85a3:0000:0000:8a2e:0370:7334:7334:7334:7334', // invalid
    '2001:0db8:85a3:0000:0000:8a2e:0370:7334:7334:7334:7334:7334', // invalid
    '2001:0db8:85a3:0000:0000:8a2e:0370:7334:7334:7334:7334:7334:7334', // invalid
    '2001:0db8:85a3:0000:0000:8a2e:037',
    '300.168.0.1', // invalid
    '192.300.0.1', // invalid
    '192.168.300.1', // invalid
    '192.168.0.300', // invalid
    '192.168.0.256', // invalid
    '2001:0db8:85a3:0000:0000:8a2e:0370:7334:', // invalid
    '2001::85a3::8a2e::0370::7334', // invalid
    '2001:0db8:85a3:0000:0000:8a2e:0370:', // invalid
    '2001::85a3::8a2e::0370', // invalid

    ]
);

it(
    'Validator::validate() should detect valid ipv6 addresses.',
    function (string $ip) {

        $validator = new Validator(
            [
            'ip' => $ip,
            ]
        );

        $validator->validate(
            [
            'ip' => 'ipv6'

            ]
        );

        expect($validator->passes())->toBeTruthy()
        ->and($validator->fails())->toBeFalsy();
    }
)->with('valid_ipv6_addresses');


it(
    'Validator::validate() should detect invalid ipv6 addresses.',
    function (string $ip) {

        $validator = new Validator(
            [
            'ip' => $ip,
            ]
        );

        $validator->validate(
            [
            'ip' => 'ipv6'
            ]
        );

        expect($validator->passes())->toBeFalsy()
        ->and($validator->fails())->toBeTruthy();
    }
)->with('invalid_ipv6_addresses');
