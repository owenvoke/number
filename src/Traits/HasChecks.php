<?php

declare(strict_types=1);

namespace Worksome\Number\Traits;

use BCMath\Number as BCNumber;
use Worksome\Number\Number;

/**
 * @mixin Number
 */
trait HasChecks
{
    /**
     * Check if this number has a decimal, even if the value is `x.0`
     */
    public function hasDecimal(): bool
    {
        return str_contains($this->toString(), Number::DECIMAL_SEPARATOR);
    }

    /**
     * Check if this number is a round whole number, either an integer or
     * a decimal consisting of only zeros
     */
    public function isRound(): bool
    {
        return ! $this->hasDecimal() || preg_match('/\.0+$/', (string) $this->value);
    }

    /**
     * An alias of the eq() function
     */
    public function isEqualTo(Number|BCNumber|string|int|float $value): bool
    {
        return $this->eq((string) $value);
    }

    /**
     * An alias of the lt() function
     */
    public function isLessThan(Number|BCNumber|string|int|float $value): bool
    {
        return $this->lt((string) $value);
    }

    /**
     * An alias of the lte() function
     */
    public function isLessThanOrEqualTo(Number|BCNumber|string|int|float $value): bool
    {
        return $this->lte((string) $value);
    }

    /**
     * An alias of the gt() function
     */
    public function isGreaterThan(Number|BCNumber|string|int|float $value): bool
    {
        return $this->gt((string) $value);
    }

    /**
     * An alias of the gte() function
     */
    public function isGreaterThanOrEqualTo(Number|BCNumber|string|int|float $value): bool
    {
        return $this->gte((string) $value);
    }

    /**
     * Check if the number is zero
     *
     * An alias of the eq(0) function
     */
    public function isZero(): bool
    {
        return $this->eq(0);
    }

    /**
     * Check if the number is less than zero
     */
    public function isNegative(): bool
    {
        return $this->lt(0);
    }
    /**
     * Check if the number is less than or equal to zero
     */
    public function isNegativeOrZero(): bool
    {
        return $this->lte(0);
    }

    /**
     * Check if the number is greater than zero
     */
    public function isPositive(): bool
    {
        return $this->gt(0);
    }

    /**
     * Check if the number is greater than or equal to zero
     */
    public function isPositiveOrZero(): bool
    {
        return $this->isZero() || $this->isPositive();
    }

    /**
     * Check if the number is a palindrome
     */
    public function isPalindrome(): bool
    {
        $value = str_replace(Number::DECIMAL_SEPARATOR, '', $this->abs()->toString());
        $half = (int) ceil(strlen($value) / 2);

        $start = substr($value, 0, $half);
        $end = substr(strrev($value), 0, $half);

        return $start === $end;
    }

    /**
     * Check if the number is visible by the given number. The result is considered
     * truthy if the division result is a round number.
     */
    public function isDivisibleBy(Number|BCNumber|string|int|float ...$num): bool
    {
        foreach ($num as $number) {
            $result = $this->div($number);

            if ($result->isRound()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the number is a prime number
     */
    public function isPrime(): bool
    {
        if ($this->hasDecimal()) {
            return false;
        }

        $num = $this->toInteger();

        // Check if the number is less than 2
        if ($num < 2) {
            return false;
        }

        // Check if the number is 2 or 3
        if ($num === 2 || $num === 3) {
            return true;
        }

        // Check if the number is divisible by 2 or 3
        if ($num % 2 === 0 || $num % 3 === 0) {
            return false;
        }

        // Check for prime numbers up to the square root of the number
        $sqrt = sqrt($num);

        for ($i = 5; $i <= $sqrt; $i += 6) {
            if ($num % $i === 0 || $num % ($i + 2) === 0) {
                return false;
            }
        }

        // If no divisor was found, it's a prime number
        return true;
    }

    /**
     * Check if the number is an even number
     */
    public function isEven(): bool
    {
        return $this->abs()->mod(2)->eq(0);
    }

    /**
     * Check if the number is an odd number
     */
    public function isOdd(): bool
    {
        return $this->abs()->mod(2)->eq(1);
    }

    /**
     * Check if the number is in the list of numbers provided
     */
    public function in(Number|BCNumber|string|int|float ...$numbers): bool
    {
        foreach ($numbers as $num) {
            if ($this->eq($num)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the number represents the same integer as the given number.
     *
     * Decimals are ignored, so "4.9" is the same integer as "4.5"
     *
     * @param int<1, 4> $roundingMode
     */
    public function isSameInteger(Number|BCNumber|string|int|float $other, int $roundingMode = PHP_ROUND_HALF_UP): bool
    {
        return $this->round($roundingMode)->toInteger() === static::of($other)->round($roundingMode)->toInteger();
    }

    /**
     * Check if the number represents the same decimal as the given number.
     *
     * Whole numbers are ignored, so "4.9" is the same decimal as "5.9"
     */
    public function isSameDecimal(Number|BCNumber|string|int|float $other): bool
    {
        $thisValue = $this->truncate()->getDecimal();
        $thatValue = static::of($other)->truncate()->getDecimal();

        return $thisValue->eq($thatValue);
    }

    /**
     * Check if the given number is between the min and max values provided
     */
    public function isBetween(Number|BCNumber|string|int|float $min, Number|BCNumber|string|int|float $max): bool
    {
        return $this->gte($min) && $this->lte($max);
    }

    /**
     * Check if this Number can be represented as an integer in PHP, taking into
     * consideration the MIN and MAX integer sizes that PHP supports.
     */
    public function isIntegerSafe(): bool
    {
        return $this->isBetween(PHP_INT_MIN, PHP_INT_MAX);
    }

    /**
     * Check if this Number can be represented as an integer in PHP, taking into
     * consideration the MIN and MAX integer sizes that PHP supports.
     */
    public function isFloatSafe(): bool
    {
        return $this->isBetween(PHP_FLOAT_MIN, PHP_FLOAT_MAX);
    }
}
