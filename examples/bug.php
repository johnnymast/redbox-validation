<?php
declare(strict_types=1);

require __DIR__ . '/autoload.php';

use Redbox\Validation\Validator;

$data = ['name' => 'blabla'];
$validator = new Validator($data);


$validator->validate(
    [
//        'name' => 'required|email|unique:users',
        'name' => 'string',
//        'name' => 'required|email|unique:users',
//                    'email' => 'required|email|unique:users',
//                    'password' => 'required|min:6|confirmed',
    ]
);


//            return redirect('https://www.google.com');
if ($validator->fails()) {
//                throw new ValidationException($validator->errors());

}

echo "DONE";
