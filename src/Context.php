<?php

/*
 * This file is part of the Redbox-validator package.
 *
 * (c) Johnny Mast <mastjohnny@gmail.com
 *
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Redbox\Validation;

use PhpParser\Node\VarLikeIdentifier;

/**
 * Context.php
 *
 * The main validator class.
 *
 * PHP version 8.1
 *
 * @category Resolver
 * @package  Core
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/johnnymast/redbox-validation
 * @since    1.0
 */
class Context
{
    protected Validator $validator;
    private bool $isValid = false;
    public string $error = '';
    public mixed $value = '';
    public string $key = '';

    /**
     * @param string $name
     * @param mixed  $method
     */
    public function __construct(public string $name, protected mixed $method)
    {
    }


    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }



    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function setError(string $error): bool
    {
        if ($this->validator) {
            $this->validator->addError($this->key, $error);
        }
        return false;
    }

    public function run(string $key, mixed $value, Validator $validator): Context
    {
        $this->validator = $validator;
        $this->key = $key;
        $this->value = $value;

        $this->isValid = call_user_func($this->method, $this);
        return $this;
    }
}