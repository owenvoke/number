<?php

declare(strict_types=1);

namespace Worksome\Number\Traits;

use BCMath\Number as BCNumber;
use Exception;
use Worksome\Number\Number;

/**
 * @mixin Number
 */
trait HasModifications
{
    /**
     * Return the absolute (positive) value of this number
     */
    public function abs(): static
    {
        $abs = str_replace(Number::NEGATIVE_SYMBOL, '', $this->toString());

        return static::of($abs);
    }

    /**
     * Negative this number.
     *
     * Positive numbers become negative.
     * Negative numbers become positive.
     */
    public function negate(): static
    {
        return static::zero()->sub($this->value);
    }

    /**
     * Artificially increase the precision of this number, by increasing the
     * scale to the scale provided. Pad zero decimals to the scale length.
     *
     * E.g. "5.4" with scale 4 -> "5.4000"
     */
    public function increaseScale(int $scale): static
    {
        [$whole, $decimal] = static::parseFragments($this->value);
        $decimal = str_pad($decimal, $scale, Number::ZERO, STR_PAD_RIGHT);

        $number = $whole . Number::DECIMAL_SEPARATOR . $decimal;

        return static::of($number);
    }

    /**
     * Increase the number tenfold, the given amount of times
     */
    public function raiseTenfold(Number|BCNumber|string|int|float $times = 1): static
    {
        $times = static::of($times);

        if ($times->hasDecimal()) {
            throw new Exception('Raise Tenfold does not accept decimal values');
        }

        $times = static::of(Number::TEN)->pow($times, 0, 0);

        return $this->mul($times);
    }

    /**
     * Decrease the number tenfold, the given amount of times
     */
    public function reduceTenfold(Number|BCNumber|string|int|float $times = 1, int|null $scale = null): static
    {
        $times = static::of($times);

        if ($times->hasDecimal()) {
            throw new Exception('Raise Tenfold does not accept decimal values');
        }

        $times = static::of(Number::TEN)->pow($times, 0, 0);

        return $this->div($times, $scale);
    }
}
