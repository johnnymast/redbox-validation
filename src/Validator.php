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

use Redbox\Validation\Exceptions\ValidationException;
use Redbox\Validation\Exceptions\ValidationDefinitionException;

class Validator
{
    /**
     * Container for the user
     * defined validation rules.
     *
     * @var array
     */
    protected array $rules = [];

    /**
     * Container for the build-in
     * validation types.
     *
     * @var array
     */
    protected array $types = [];

    /**
     * Container for validation
     * errors.
     *
     * @var array
     */
    protected array $errors = [];

    /**
     * Did the validation pass
     * yes or no?
     *
     * @var bool
     */
    protected bool $didPass = true;

    /**
     * Validator constructor.
     *
     * @param array $target The array to validate.
     */
    public function __construct(protected array $target = [])
    {
        $this->defineTypes();
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    private function defineTypes()
    {
        $this->types = \Redbox\Validation\TypeResolver::resolveTypes(
            [
                \Redbox\Validation\ValidationTypes\TypeDefinitions::class,
            ]
        );
    }

    /**
     * Users can define their
     * own custom validation types.
     *
     * @param array $classes
     *
     * @return void
     * @throws \ReflectionException
     */
    public function defineCustomTypes(array $classes = [])
    {
        $this->types = array_merge($this->types, \Redbox\Validation\TypeResolver::resolveTypes($classes));
    }

    /**
     * Return the defined rules. This function
     * is mostly used for testing.
     *
     * @return array
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * Process rules for the target array.
     *
     * @param string $key   The key from the target array.
     * @param mixed  $rules Validation rules for the key.
     *
     * @return void
     * @throws ValidationDefinitionException
     */
    private function addRule(string $key, mixed $rules): void
    {
        $this->rules[$key] = match (strtolower(get_debug_type($rules))) {
            'closure' => [$rules],
            'array' => $rules,
            'string' => (strpos($rules, '|') > -1) ? explode('|', $rules) : [$rules],
            default => throw new ValidationDefinitionException("Unknown validation rule type."),
        };

        foreach ($this->rules as $key => $types) {
            foreach ($types as $type) {
                if (!is_callable($type)) {
                    if (!isset($this->types[$type])) {
                        throw new ValidationDefinitionException("Unknown validation rule type.");
                    }
                }
            }
        }

        // TODO: validate rules
        // TODO: Validate closures
    }

    /**
     * Validate the target array.
     *
     * <code>
     * <?php
     * try {
     *     $validator = new Redbox\Validation\Validator(['test' => true]);
     *     $data = $validator->validate(['test' => 'boolean']);
     *
     *     // Success
     *     print_r($data);
     *
     * } catch (ValidationException $e) {
     *     print_r($validator->getErrors());
     * }
     * ?>
     * </code>
     *
     * @param array $definitions The validation rules.
     *
     * @return array
     * @throws ValidationDefinitionException
     * @throws ValidationException
     */
    public function validate(array $definitions): array
    {

        $this->errors = $this->rules = [];
        $this->didPass = true;
        $fails = 0;

        foreach ($definitions as $key => $rules) {
            $this->addRule($key, $rules);
        }

        foreach ($this->rules as $key => $rule) {
            foreach ($rule as $name) {
                $context = null;
                if (is_callable($name)) {
                    $context = new ValidationContext('closure', $name);
                } elseif (isset($this->types[$name])) {
                    $context = $this->types[$name];
                }

                $didPass = $context->run($key, $this->target[$key] ?? '', $this->target, $this)
                    ->isPassing();

                if (!$didPass) {
                    $fails++;
                }
            }
        }

        if ($fails > 0) {
            $this->didPass = false;
            throw new ValidationException("Validator failed");
        }

        return $this->target;
    }

    /**
     * Indicate if the validation
     * has passed.
     *
     * @return bool
     */
    public function didPass(): bool
    {
        return $this->didPass;
    }

    /**
     * The context will call this function is a test fails.
     *
     * @param string $key   The name of the key in the target array.
     * @param string $error The error string.
     *
     * @return void
     */
    public function addError(string $key, string $error)
    {
        $this->errors[$key] = $error;
    }

    /**
     * This function can be called to check
     * if there are any validation errors.
     *
     * @return bool
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Return the errors.
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
