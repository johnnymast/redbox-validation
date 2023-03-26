
# Redbox-package-skeleton (WIP)

This is just a skeleton for my php packages.

[![Unit Tests](https://github.com/johnnymast/redbox-validation/actions/workflows/Tests.yml/badge.svg)](https://github.com/johnnymast/redbox-validation/actions/workflows/Tests.yml)
[![PhpCS](https://github.com/johnnymast/redbox-validation/actions/workflows/Phpcs.yaml/badge.svg)](https://github.com/johnnymast/redbox-validation/actions/workflows/Phpcs.yaml)
[![PhpCS](https://raw.githubusercontent.com/johnnymast/redbox-validation/master/badges/coverage-badge.svg)](https://github.com/johnnymast/redbox-validation/actions/workflows/pest-coverage.yaml)

## installation

```bash
$ composer create-project -sdev redbox/redbox-package-skeleton ./skel/
```

## Usage

```php 
try {
   $validator = new Redbox\Validation\Validator(['test' => true]);
   $data = $validator->validate(['test' => 'boolean']);

    // Success
    print_r($data);

} catch (ValidationException $e) {
   print_r($validator->getErrors());
}
```

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
