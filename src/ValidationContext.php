<?php

/**
 * This file is part of the Redbox-validator package.
 *
 * (c) Johnny Mast <mastjohnny@gmail.com
 *
 * PHP version 8.1
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Redbox\Validation;

class ValidationContext
{
    /**
     * @var Validator
     */
    protected Validator $validator;
    /**
     * @var string
     */
    public string $error = '';
    /**
     * @var mixed|string
     */
    public mixed $value = '';
    /**
     * @var string
     */
    public string $key = '';

    protected array $target = [];

    protected bool $didPass = true;

    /**
     * @param string $name
     * @param array  $target
     * @param mixed  $method
     */
    public function __construct(public string $name, protected mixed $method)
    {
    }

    /**
     * Check if the key exists on the target
     * array.
     *
     * @return bool
     */
    public function keyExists(): bool
    {
        return isset($this->target[$this->key]);
    }

    public function isPassing(): bool
    {
        return $this->didPass;
    }

    /**
     * @return array
     */
    public function getTarget(): array
    {
        return $this->target;
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

    /**
     * @param string $error
     *
     * @return bool
     */
    public function setError(string $error): bool
    {
        if ($this->validator) {
            $this->validator->addError($this->key, $error);
        }
        return false;
    }

    /**
     * Run the test rule.
     *
     * @param string    $key       The key from the target array.
     * @param mixed     $value     The value from the target array.
     * @param array     $target    The target array.
     * @param Validator $validator The validator.
     *
     * @return $this
     */
    public function run(string $key, mixed $value, array $target, Validator $validator): ValidationContext
    {
        $this->validator = $validator;
        $this->key = $key;
        $this->value = $value;
        $this->target = $target;

        $this->didPass = call_user_func($this->method, $this);
        return $this;
    }
}
