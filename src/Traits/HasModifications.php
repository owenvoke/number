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
    public function abs(): static
    {
        $abs = str_replace(Number::NEGATIVE_SYMBOL, '', $this->toString());

        return static::of($abs);
    }

    public function negate(): static
    {
        return static::zero()->sub($this->value);
    }

    public function toScale(int $scale): static
    {
        [$whole, $decimal] = static::parseFragments($this->value);
        $decimal = str_pad($decimal, $scale, Number::ZERO, STR_PAD_RIGHT);

        $number = $whole . Number::DECIMAL_SEPARATOR . $decimal;

        return static::of($number);
    }

    public function raiseTenfold(Number|BCNumber|string|int|float $times = 1): static
    {
        $times = static::of($times);

        if ($times->hasDecimal()) {
            throw new Exception('Raise Tenfold does not accept decimal values');
        }

        $times = static::of(Number::TEN)->pow($times, 0, 0);

        return $this->mul($times);
    }

    public function reduceTenfold(Number|BCNumber|string|int|float $times = 1, ?int $scale = null): static
    {
        $times = static::of($times);

        if ($times->hasDecimal()) {
            throw new Exception('Raise Tenfold does not accept decimal values');
        }

        $times = static::of(Number::TEN)->pow($times, 0, 0);

        return $this->div($times, $scale);
    }
}
