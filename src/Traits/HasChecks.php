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
    public function hasDecimal(): bool
    {
        return str_contains($this->toString(), Number::DECIMAL_SEPARATOR);
    }

    public function isRound(): bool
    {
        return ! $this->hasDecimal() || preg_match('/\.0+$/', (string) $this->value);
    }

    public function isEqualTo(Number|BCNumber|string|int|float $value): bool
    {
        return $this->eq((string) $value);
    }

    public function isLessThan(Number|BCNumber|string|int|float $value): bool
    {
        return $this->lt((string) $value);
    }

    public function isLessThanOrEqualTo(Number|BCNumber|string|int|float $value): bool
    {
        return $this->lte((string) $value);
    }

    public function isGreaterThan(Number|BCNumber|string|int|float $value): bool
    {
        return $this->gt((string) $value);
    }

    public function isGreaterThanOrEqualTo(Number|BCNumber|string|int|float $value): bool
    {
        return $this->gte((string) $value);
    }

    public function isZero(): bool
    {
        return $this->eq(0);
    }

    public function isNegative(): bool
    {
        return $this->lt(0);
    }

    public function isNegativeOrZero(): bool
    {
        return $this->isZero() || $this->isNegative();
    }

    public function isPositive(): bool
    {
        return $this->gt(0);
    }

    public function isPositiveOrZero(): bool
    {
        return $this->isZero() || $this->isPositive();
    }

    public function isPalindrome(): bool
    {
        $value = str_replace(Number::DECIMAL_SEPARATOR, '', $this->abs()->toString());
        $half = (int) ceil(strlen($value) / 2);

        $start = substr($value, 0, $half);
        $end = substr(strrev($value), 0, $half);

        return $start === $end;
    }

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

    public function isEven(): bool
    {
        return $this->abs()->mod(2)->eq(0);
    }

    public function isOdd(): bool
    {
        return $this->abs()->mod(2)->eq(1);
    }

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
     * Does this number have the same integer fragment as the $other number?
     */
    public function isSameInteger(Number|BCNumber|string|int|float $other): bool
    {
        return $this->round()->toInteger() === static::of($other)->round()->toInteger();
    }

    /**
     * Does this number have the same decimal fragment as the $other number?
     */
    public function isSameDecimal(Number|BCNumber|string|int|float $other): bool
    {
        $thisValue = $this->truncate()->getDecimal();
        $thatValue = static::of($other)->truncate()->getDecimal();

        return $thisValue->eq($thatValue);
    }

    /**
     * Can this Number be represented as an integer in PHP, taking into
     * consideration the MIN and MAX integer sizes that PHP supports.
     */
    public function isIntegerSafe(): bool
    {
        return $this->gte(PHP_INT_MIN) && $this->lte(PHP_INT_MAX);
    }
}
