<?php

namespace Redbox\Validation\Resolver;

use PhpParser\Builder\Class_;
use Redbox\Validation\Attributes\ValidationRule;

class Resolver
{

    public function __construct()
    {
    }

    private function resolve(string $class, string $attibute): array
    {
        $reflectionObject = new \ReflectionClass($class);
        $intance = new $class;
        $callables = [];

        $attributes = $reflectionObject->getAttributes($attibute);
        foreach ($attributes as $attibute) {
            print_r($attibute);

//            $callables[] = [new $method->class, $method->name];
            /**
             * Weird but still be need to do this.
             */
//            new $this->annotationClass;

            /**
             * Autoload or instantiate the object
             */
//            $annotation = $this->reader->getMethodAnnotation($reflectionMethod, $this->annotationClass);

//            Filters::addFilter(
//                $annotation->getPropertyName(),
//                [$object, $reflectionMethod->name],
//                $annotation->priority
//            );
        }

        return $callables;
    }

    public static function resolveRules(array $classes): array
    {
        $instance = new static();
        $result = [];

        if (count($classes) > 0) {
            foreach ($classes as $class) {
                $resolved = $instance->resolve($class, ValidationRule::class);
                if ($resolved) {
                    $result[] = $resolved;
                }
            }
        }

        return $result;
    }

}