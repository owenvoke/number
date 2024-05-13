<?php

declare(strict_types=1);

namespace Worksome\Number\Exceptions;

use Exception;

class AtLeastOneNumberRequiredException extends Exception implements NumberException
{
    public static function method(string $method): self
    {
        return new self(
            sprintf(
                'At least one number is required to calculate the %s of numbers',
                $method,
            ),
        );
    }
}
