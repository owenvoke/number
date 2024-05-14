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
     * Get the Roman Numerals equivalent of this value.
     *
     * Not super great for values far beyond 1 million. Romans rarely used
     * numerals for depicting such large numbers -- apparently often used
     * words instead.
     */
    public function toRomanNumerals(): string
    {
        $num = $this->toInteger();

        $map = [
            'M̅' => 1_000_000,
            'D̅' => 500_000,
            'C̅' => 100_000,
            'L̅' => 50_000,
            'X̅' => 10_000,
            'V̅' => 5_000,
            'M' => 1_000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1,
        ];

        $roman = '';

        foreach ($map as $romanNumeral => $value) {
            while ($num >= $value) {
                $roman .= $romanNumeral;
                $num -= $value;
            }
        }

        return $roman;
    }

    /**
     * Get the decimal portion of this number
     */
    public function extractDecimal(): static
    {
        [$whole, $decimal] = Parser::parseFragments($this->value);

        if ($decimal === '') {
            return static::zero();
        }

        return static::of($decimal);
    }

    /**
     * Get the integer portion of this number
     */
    public function extractInteger(): static
    {
        [$whole, $decimal] = Parser::parseFragments($this->value);

        if ($decimal === '') {
            return static::zero();
        }

        return static::of($decimal);
    }
}
