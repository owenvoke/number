<?php

declare(strict_types=1);

namespace Worksome\Number\Traits;

use Worksome\Number\Number;
use Worksome\Number\Parser;

/**
 * @mixin Number
 */
trait HasOutputTo
{
    /**
     * Cast the number object to string.
     */
    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * Get the string value of this number
     */
    public function toString(): string
    {
        return $this->value->value;
    }

    /**
     * Get the integer value of this number
     */
    public function toInteger(): int
    {
        return (int) $this->value->value;
    }

    /**
     * Get the float value of this number
     */
    public function toFloat(): float
    {
        return (float) $this->value->value;
    }

    /**
     * Get the decimal portion of this number
     */
    public function extractDecimal(): static
    {
        return static::of(Parser::parseDecimalNumber($this->value) ?? '');
    }

    /**
     * Get the integer portion of this number
     */
    public function extractInteger(): static
    {
        return static::of(Parser::parseWholeNumber($this->value));
    }
}
