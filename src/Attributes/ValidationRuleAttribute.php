<?php

namespace Redbox\Validation\Attributes;

use Attribute;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_METHOD)]
class ValidationRule
{
    protected string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

}