<?php

declare(strict_types=1);

namespace Worksome\Number;

use Worksome\Number\Exceptions\InvalidValueException;

class StrictPercentage extends Percentage
{
    protected function validate(): void
    {
        if ($this->isLessThan(0) || $this->isGreaterThan(100)) {
            throw new InvalidValueException(
                sprintf(
                    'The provided value "%s" is not a valid percentage',
                    $this->value->toFloat()
                )
            );
        }
    }
}
