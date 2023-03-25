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

use Redbox\Validation\Attributes\ValidationRule;
use Redbox\Validation\ValidationTypes\TypeDefinition;

/**
 * Resolver.php
 *
 * A Support class that will find validation types.
 *
 * PHP version 8.1
 *
 * @category Resolver
 * @package  Redbox-validator
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/johnnymast/redbox-validation
 * @since    1.0
 */
class TypeResolver
{

    /**
     * Filter validation types defined by the given attribute.
     *
     * @param string $class Find Validation types in this class.
     * @param string $attr  The name of the attribute to find.
     *
     * @return array
     * @throws \ReflectionException
     */
    private function resolve(string $class, string $attr): array
    {
        $reflection = new \ReflectionClass($class);
        $callables = [];

        foreach ($reflection->getMethods() as $method) {
            $attributes = $method->getAttributes($attr);
            $instance = $reflection->newInstance();

            foreach ($attributes as $attribute) {
                $type = $attribute->newInstance();
                $callables[$type->name] = new Context($type->name, [$instance, $method->name]);
            }
        }

        return $callables;
    }


    /**
     * Read the validation types from a class.
     *
     * @param array $classes an array of classes to resolve attributes from/
     *
     * @return array
     * @throws \ReflectionException
     */
    public static function resolveTypes(array $classes): array
    {
        $instance = new static();
        $result = [];

        if (count($classes) > 0) {
            foreach ($classes as $class) {
                $resolved = $instance->resolve($class, ValidationRule::class);
                if ($resolved) {
                    $result += $resolved;
                }
            }
        }

        return $result;
    }
}