<?php

namespace Redbox\Validation;

use Redbox\Validation\Resolver\Resolver;
use Redbox\Validation\ValidationRules\TypeDefinitionRules;

class Validator
{
    protected string $ruleSperator = '|';

    protected array $rules = [];
    protected array $target = [];

    public function __construct(array $target = [])
    {
        $this->target = $target;

        $this->defineRules();
    }

    private function defineRules()
    {
        $this->definedRules = Resolver::resolveRules([
            TypeDefinitionRules::class,
        ]);
    }

    public function getRules(): array
    {
        return $this->rules;
    }

    public function validate(string $key, $rules): Validator
    {

        if (is_array($rules)) {
            $this->rules[$key] = $rules;
        } else if (is_string($rules)) {

            if (strpos($rules, $this->ruleSperator) > -1) {
                $this->rules[$key] = explode($this->ruleSperator, $rules);
            } else {
                $this->rules[$key] = [$rules];
            }
        } else if (is_callable($rules)) {
            $this->rules[$key] = [$rules];
        }


        //throw new \ValidationDefinitionException("Could not parse rule set.");


        return $this;

    }

    function validateRules()
    {
    }


}