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

declare(strict_types=1);

namespace Redbox\Validation;

use Redbox\Validation\Exceptions\ValidationException;
use Redbox\Validation\Exceptions\ValidationDefinitionException;

/**
 * Validator.php
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
class Validator
{
    protected array $rules = [];
    protected array $types = [];
    protected array $errors = [];

    /**
     * Validator constructor.
     *
     * @param array $target The array to validate.
     */
    public function __construct(protected array $target = [])
    {
        $this->defineRules();
    }

    private function defineRules()
    {
        $this->types = \Redbox\Validation\TypeResolver::resolveTypes([
            \Redbox\Validation\ValidationTypes\TypeDefinitions::class,
        ]);
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
     * @param $key
     * @param $rules
     *
     * @return void
     * @throws ValidationDefinitionException
     */
    private function addRule($key, $rules): void
    {
        $this->rules[$key] = match (strtolower(get_debug_type($rules))) {
            'closure' => [$rules],
            'array' => $rules,
            'string' => (strpos($rules, '|') > -1) ? explode('|', $rules) : [$rules],
            default => throw new ValidationDefinitionException("Unknown validation rule type."),
        };


        // TODO: validate if rule keys exist in target
        // TODO: validate rules
    }

    /**
     **
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
     * @returns array
     */
    public function validate(array $definitions): array
    {

        $this->errors = $this->rules = [];

        foreach ($definitions as $key => $rules) {
            $this->addRule($key, $rules);
        }

        foreach ($this->rules as $key => $rule) {
            foreach ($rule as $name) {
                if (isset($this->types[$name]) && isset($this->target[$key])) {
                    $this->types[$name]->run($key, $this->target[$key], $this);
                }
            }
        }

        if ($this->hasErrors()) {
            throw new ValidationException("Validator failed");
        }

        return $this->target;
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