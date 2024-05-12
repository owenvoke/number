<?php

declare(strict_types=1);

namespace Worksome\Number;

use BCMath;
use Illuminate\Support\Traits\Macroable;

/** @mixin BCMath\Number */
class Number
{
    use Macroable {
        __call as macroCall;
    }

    public readonly BCMath\Number $value;

    public function __construct(
        Number|BCMath\Number|string|int $value,
    ) {
        $this->value = match (true) {
            $value instanceof BCMath\Number => $value,
            $value instanceof Number => $value->value,
            default => new BCMath\Number($value),
        };

        $this->validate();
    }

    public static function of(Number|BCMath\Number|string|int|float $value): Number
    {
        if ($value instanceof Number) {
            return new Number($value->value);
        }

        if ($value instanceof BCMath\Number) {
            return new Number($value);
        }

        if (is_int($value)) {
            return new Number($value);
        }

        return new Number(new BCMath\Number((string) $value));
    }

    public function percentage(Number $number): Number
    {
        return $this->value->div(100)->mul($number);
    }

    public function negate(): Number
    {
        return new Number("-{$this->value}");
    }

    public function isEqualTo(Number $value): bool
    {
        return $this->value->eq($value->value);
    }

    public function isLessThan(Number $value): bool
    {
        return $this->value->lt($value->value);
    }

    public function isLessThanOrEqualTo(Number $value): bool
    {
        return $this->value->lte($value);
    }

    public function isGreaterThan(Number $value): bool
    {
        return $this->value->gt($value->value);
    }

    public function isGreaterThanOrEqualTo(Number $value): bool
    {
        return $this->value->gte($value);
    }

    public function isZero(): bool
    {
        return $this->value->eq(0);
    }

    public function isNegative(): bool
    {
        return $this->value->lt(0);
    }

    public function isNegativeOrZero(): bool
    {
        return $this->isZero() || $this->isNegative();
    }

    public function isPositive(): bool
    {
        return $this->value->gt(0);
    }

    public function isPositiveOrZero(): bool
    {
        return $this->isZero() || $this->isPositive();
    }

    public function toString(): string
    {
        return (string) $this->value;
    }

    public function toFloat(): float
    {
        return (float) $this->value;
    }

    /** @TODO: This should be moved to a money package. */
    public function inCents(): int
    {
        return (int) $this->value->mul(100);
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function __call($method, $parameters): mixed
    {
        if (method_exists($this->value, $method)) {
            $value = $this->value->{$method}(...$parameters);

            return $value instanceof BCMath\Number ? new Number($value) : $value;
        }

        return $this->macroCall($method, $parameters);
    }

    protected function validate(): void
    {
    }
}
