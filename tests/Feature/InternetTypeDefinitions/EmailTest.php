<?php

namespace Redbox\Validation\Tests\Feature\InternetTypeDefinitions;

use Redbox\Validation\Validator;

dataset(
    'invalid_emails',
    [
    'test',
    'test@',
    'test@.com',
    'test@com',
    'test@.com.com',
    'test+test@.com',
    'test@%*.com',
    'test..',
    ]
);

dataset(
    'valid_emails',
    [
    'omething@something.com',
    'abc@gmail.com',
    'mastjohnny@gmail.com',
    'roadrunner@hotmail.com',
    'abc123@outlook.com',
    ]
);

it(
    'Validator::validate() should detect valid email addresses.',
    function ($email) {

        $validator = new Validator(
            [
            'email' => $email,
            ]
        );

        $validator->validate(
            [
            'email' => 'email'
            ]
        );

        expect($validator->passes())->toBeTruthy()
        ->and($validator->fails())->toBeFalsy();
    }
)->with('valid_emails');


it(
    'Validator::validate() should detect invalid email addresses.',
    function ($email) {

        $validator = new Validator(
            [
            'email' => $email,
            ]
        );

        $validator->validate(
            [
            'email' => 'email'
            ]
        );

        expect($validator->passes())->toBeFalsy()
        ->and($validator->fails())->toBeTruthy();
    }
)->with('invalid_emails');
