<?php

declare(strict_types=1);

namespace Worksome\Number\Traits;

use Worksome\Number\Number;

/**
 * @mixin Number
 */
trait HasOutputTo
{
    public function __toString(): string
    {
        return $this->toString();
    }

    public function toString(): string
    {
        return $this->value->value;
    }

    public function toInteger(): int
    {
        return (int) $this->value->value;
    }

    public function toFloat(): float
    {
        return (float) $this->value->value;
    }

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

    public function getDecimal(): static
    {
        [$whole, $decimal] = static::parseFragments($this->value);

        if ($decimal === '') {
            return static::zero();
        }

        return static::of($decimal);
    }

    public function getInteger(): static
    {
        [$whole, $decimal] = static::parseFragments($this->value);

        if ($decimal === '') {
            return static::zero();
        }

        return static::of($decimal);
    }
}
