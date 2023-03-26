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

namespace Redbox\Validation\Tests\Types;

use Redbox\Validation\Attributes\ValidationRule;
use Redbox\Validation\ValidationContext;

class TestDefinitions
{
    #[ValidationRule('foo')]
    public function foo(ValidationContext $context): bool
    {
        return true;
    }

    #[ValidationRule('bar')]
    public function bar(ValidationContext $context): bool
    {
        return true;
    }

    #[ValidationRule('baz')]
    public function baz(ValidationContext $context): bool
    {
        return true;
    }

    #[ValidationRule('qux')]
    public function qux(ValidationContext $context): bool
    {
        return true;
    }
}
