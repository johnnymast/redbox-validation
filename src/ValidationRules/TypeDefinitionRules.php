<?php

namespace Redbox\Validation\ValidationRules;

use Redbox\Validation\Attributes\ValidationRule;

class TypeDefinitionRules
{

    #[ValidationRule(name: 'boolean')]
    public function isBoolean() {

    }
}