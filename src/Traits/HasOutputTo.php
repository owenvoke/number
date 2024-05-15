<?php

declare(strict_types=1);

namespace Worksome\Number\Traits;

use Worksome\Number\Number;

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
        $num = $this->value->value;
        $pos = strpos($num, Number::DECIMAL_SYMBOL);

        $decimal = ($pos === false) ? '0' : substr($num, $pos + 1);

        return static::of($decimal);
    }

    /**
     * Get the integer portion of this number
     */
    public function extractInteger(): static
    {
        $num = $this->value->value;
        $pos = strpos($num, Number::DECIMAL_SYMBOL);

        $integer = ($pos === false) ? $num : substr($num, 0, $pos);

        return static::of($integer);
    }
}
