<?php

namespace Redbox\Validation\Attributes;

use Attribute;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_ALL)]
class ValidationRule
{
    public function __construct(public $name)
    {
    }
}
