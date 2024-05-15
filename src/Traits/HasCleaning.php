<?php

declare(strict_types=1);

namespace Worksome\Number\Traits;

use Worksome\Number\Number;

/**
 * @mixin Number
 */
trait HasCleaning
{
    /**
     * Remove trailing zero decimals down to the given min scale
     */
    public function clean(int $minScale): static
    {
        $wholeNumber = $this->extractInteger();

        if ($this->hasDecimal() === false) {
            return $wholeNumber;
        }

        $decimalNumber = $this->extractDecimal()->value->value;

        $decimalKeep = substr($decimalNumber, 0, $minScale);
        $decimalTail = substr($decimalNumber, $minScale);
        $decimalTail = rtrim($decimalTail, Number::ZERO);

        if ($minScale === 0 && $decimalTail === '') {
            return $wholeNumber;
        }

        $cleaned = $wholeNumber->value . Number::DECIMAL_SYMBOL . $decimalKeep . $decimalTail;

        return static::of($cleaned);
    }

    /**
     * Remove any and all trailing zero decimals
     */
    public function truncate(): static
    {
        return $this->clean(0);
    }
}
