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

namespace Redbox\Validation;

class ValidationContext
{
    /**
     * Reference to the validator
     * class.
     *
     * @var Validator|null
     */
    protected ?Validator $validator = null;

    /**
     * The value to validate.
     *
     * @var mixed|string
     */
    public mixed $value = '';

    /**
     * The key in the target
     * array.
     *
     * @var string
     */
    public string $key = '';

    /**
     * Reference to the target
     * array.
     *
     * @var array
     */
    protected array $target = [];

    /**
     * Indicator to see if
     * the validation passed.
     *
     * @var bool
     */
    protected bool $passes = true;

    /**
     * Custom error string defined by the user.
     *
     * @var string
     */
    protected string $customErrorMessage = '';

    /**
     * ValidationContext constructor.
     *
     * @param string $name   The name of the validation type.
     * @param mixed  $method The method to call to validate the value.
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

    /**
     * Returns true if the
     * test has failed.
     *
     * @return bool
     */
    public function fails(): bool
    {
        return ($this->passes === false);
    }

    /**
     * Returns true if the
     * test was successful.
     *
     * @return bool
     */
    public function passes(): bool
    {
        return $this->passes;
    }

    /**
     * Return the value of the
     * key in the target array.
     *
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * Return the name of the
     * key in the target array.
     *
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Did the user defined a custom error message?
     *
     * @return bool
     */
    public function hasCustomErrorMessage(): bool
    {
        return (strlen($this->customErrorMessage) > 0);
    }

    /**
     * Return the custom error message.
     *
     * @return string
     */
    public function getsCustomErrorMessage(): string
    {
        return $this->customErrorMessage;
    }

    /**
     * Add an error in the validator.
     *
     * @param string $error The error string.
     *
     * @return bool
     */
    public function addError(string $error): bool
    {
        if ($this->validator !== null) {
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
    public function run(
        string $key,
        mixed $value,
        array $target,
        Validator $validator,
        string $customErrorMessage = ''
    ): ValidationContext {
        $this->validator = $validator;
        $this->key = $key;
        $this->value = $value;
        $this->target = $target;
        $this->customErrorMessage = $customErrorMessage;

        $this->passes = call_user_func($this->method, $this);
        return $this;
    }
}
