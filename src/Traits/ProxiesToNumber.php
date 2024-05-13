<?php

declare(strict_types=1);

namespace Worksome\Number\Traits;

use BCMath\Number as BCNumber;
use Worksome\Number\Number;

/**
 * @mixin Number
 */
trait ProxiesToNumber
{
    /**
     * @param int<1, 4> $roundingMode
     */
    public function add(
        Number|BCNumber|string|int $num,
        ?int $scale = null,
        int $roundingMode = PHP_ROUND_HALF_UP,
    ): static {
        $num = ($num instanceof Number) ? $num->value : $num;

        return static::of($this->value->add($num, $scale, $roundingMode));
    }

    /**
     * @param int<1, 4> $roundingMode
     */
    public function sub(
        Number|BCNumber|string|int $num,
        ?int $scale = null,
        int $roundingMode = PHP_ROUND_HALF_UP,
    ): static {
        $num = ($num instanceof Number) ? $num->value : $num;

        return static::of($this->value->sub($num, $scale, $roundingMode));
    }

    /**
     * @param int<1, 4> $roundingMode
     */
    public function mul(
        Number|BCNumber|string|int $num,
        ?int $scale = null,
        int $roundingMode = PHP_ROUND_HALF_UP,
    ): static {
        $num = ($num instanceof Number) ? $num->value : $num;

        return static::of($this->value->mul($num, $scale, $roundingMode));
    }

    /**
     * @param int<1, 4> $roundingMode
     */
    public function div(
        Number|BCNumber|string|int $num,
        ?int $scale = null,
        int $roundingMode = PHP_ROUND_HALF_UP,
    ): static {
        $num = ($num instanceof Number) ? $num->value : $num;

        return static::of($this->value->div($num, $scale, $roundingMode));
    }

    /**
     * @param int<1, 4> $roundingMode
     */
    public function mod(
        Number|BCNumber|string|int $num,
        ?int $scale = null,
        int $roundingMode = PHP_ROUND_HALF_UP,
    ): static {
        $num = ($num instanceof Number) ? $num->value : $num;

        return static::of($this->value->mod($num, $scale, $roundingMode));
    }

    public function powmod(Number|BCNumber|string|int $exponent, Number|BCNumber|string|int $modulus): static
    {
        $exponent = ($exponent instanceof Number) ? $exponent->value : $exponent;
        $modulus = ($modulus instanceof Number) ? $modulus->value : $modulus;

        return static::of($this->value->powmod($exponent, $modulus));
    }

    /**
     * @param int<1, 4> $roundingMode
     */
    public function pow(
        Number|BCNumber|string|int $exponent,
        int $minScale,
        ?int $scale = null,
        int $roundingMode = PHP_ROUND_HALF_UP,
    ): static {
        $exponent = ($exponent instanceof Number) ? $exponent->value : $exponent;

        return static::of($this->value->pow($exponent, $minScale, $scale, $roundingMode));
    }

    /**
     * @param int<1, 4> $roundingMode
     */
    public function sqrt(?int $scale = null, int $roundingMode = PHP_ROUND_HALF_UP): static
    {
        return static::of($this->value->sqrt($scale, $roundingMode));
    }

    public function floor(): static
    {
        return static::of($this->value->floor());
    }

    public function ceil(): static
    {
        return static::of($this->value->ceil());
    }

    /**
     * @param int<1, 4> $mode
     */
    public function round(int $precision = 0, int $mode = PHP_ROUND_HALF_UP): static
    {
        return static::of($this->value->round($precision, $mode));
    }

    public function comp(Number|BCNumber|string|int $num, ?int $scale = null): int
    {
        $num = ($num instanceof Number) ? $num->value : $num;

        return $this->value->comp($num, $scale);
    }

    public function eq(Number|BCNumber|string|int $num, ?int $scale = null): bool
    {
        $num = ($num instanceof Number) ? $num->value : $num;

        return $this->value->eq($num, $scale);
    }

    public function gt(Number|BCNumber|string|int $num, ?int $scale = null): bool
    {
        $num = ($num instanceof Number) ? $num->value : $num;

        return $this->value->gt($num, $scale);
    }

    public function gte(Number|BCNumber|string|int $num, ?int $scale = null): bool
    {
        $num = ($num instanceof Number) ? $num->value : $num;

        return $this->value->gte($num, $scale);
    }

    public function lt(Number|BCNumber|string|int $num, ?int $scale = null): bool
    {
        $num = ($num instanceof Number) ? $num->value : $num;

        return $this->value->lt($num, $scale);
    }

    public function lte(Number|BCNumber|string|int $num, ?int $scale = null): bool
    {
        $num = ($num instanceof Number) ? $num->value : $num;

        return $this->value->lte($num, $scale);
    }

    /**
     * @param int<1, 4> $roundingMode
     */
    public function format(
        ?int $scale = null,
        int $roundingMode = PHP_ROUND_HALF_UP,
        string $decimalSeparator = Number::DECIMAL_SEPARATOR,
        string $thousandsSeparator = Number::THOUSANDS_SEPARATOR,
    ): string {
        return $this->format($scale, $roundingMode, $decimalSeparator, $thousandsSeparator);
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
