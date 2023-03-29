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

class InternetTypeDefinitions
{
    #[ValidationRule('ip4')]
    public function isIPv4(ValidationContext $context): bool
    {
        return ($context->keyExists() && filter_var(
            $context->getValue(),
            FILTER_VALIDATE_IP,
            FILTER_FLAG_IPV4
        ))
            or $context->addError("Field {$context->getKey()} is not a valid IPv4 address.");
    }

    #[ValidationRule('ip6')]
    public function isIPv6(ValidationContext $context): bool
    {
        return ($context->keyExists() && filter_var(
            $context->getValue(),
            FILTER_VALIDATE_IP,
            FILTER_FLAG_IPV6
        ))
            or $context->addError("Field {$context->getKey()} is not a valid IPv6 address.");
    }


}
