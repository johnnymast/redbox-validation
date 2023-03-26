<?php

/*
 * This file is part of the Redbox-validator package.
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Redbox\Validation\ValidationTypes;

use Redbox\Validation\Attributes\ValidationRule;
use Redbox\Validation\ValidationContext;

class TypeDefinitions
{
    #[ValidationRule('boolean')]
    public function isBoolean(ValidationContext $context): bool
    {
        return ($context->keyExists() && is_bool($context->getValue()))
            or $context->setError("Field {$context->getKey()} is not of type boolean.");
    }

    #[ValidationRule('string')]
    public function string(ValidationContext $context): bool
    {
        return ($context->keyExists() && is_string($context->getValue()))
            or $context->setError("Field {$context->getKey()} is not of type string.");
    }
}
