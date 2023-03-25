<?php

namespace Redbox\Validation\ValidationTypes;

use Redbox\Validation\Attributes\ValidationRule;
use Redbox\Validation\Context;
use Redbox\Validation\Validator;

class TypeDefinitions
{

    #[ValidationRule('boolean')]
    public function isBoolean(Context $test): bool
    {
        return is_bool($test->getValue()) or $test->setError("Field {$test->getKey()} is not of type boolean.");
    }

    #[ValidationRule('booleans')]
    public function bleep(): void
    {

    }
}