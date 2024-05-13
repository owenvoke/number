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
        Number|BCNumber|string|int|float $num,
        int|null $scale = null,
        int $roundingMode = PHP_ROUND_HALF_UP,
    ): static {
        $num = $this->prepareArgumentForBCNumber($num);

        return static::of($this->value->add($num, $scale, $roundingMode));
    }

    /**
     * @param int<1, 4> $roundingMode
     */
    public function sub(
        Number|BCNumber|string|int|float $num,
        int|null $scale = null,
        int $roundingMode = PHP_ROUND_HALF_UP,
    ): static {
        $num = $this->prepareArgumentForBCNumber($num);

        return static::of($this->value->sub($num, $scale, $roundingMode));
    }

    /**
     * @param int<1, 4> $roundingMode
     */
    public function mul(
        Number|BCNumber|string|int|float $num,
        int|null $scale = null,
        int $roundingMode = PHP_ROUND_HALF_UP,
    ): static {
        $num = $this->prepareArgumentForBCNumber($num);

        return static::of($this->value->mul($num, $scale, $roundingMode));
    }

    /**
     * @param int<1, 4> $roundingMode
     */
    public function div(
        Number|BCNumber|string|int|float $num,
        int|null $scale = null,
        int $roundingMode = PHP_ROUND_HALF_UP,
    ): static {
        $num = $this->prepareArgumentForBCNumber($num);

        return static::of($this->value->div($num, $scale, $roundingMode));
    }

    /**
     * @param int<1, 4> $roundingMode
     */
    public function mod(
        Number|BCNumber|string|int|float $num,
        int|null $scale = null,
        int $roundingMode = PHP_ROUND_HALF_UP,
    ): static {
        $num = $this->prepareArgumentForBCNumber($num);

        return static::of($this->value->mod($num, $scale, $roundingMode));
    }

    public function powmod(
        Number|BCNumber|string|int|float $exponent,
        Number|BCNumber|string|int|float $modulus,
    ): static {
        $exponent = $this->prepareArgumentForBCNumber($exponent);
        $modulus = $this->prepareArgumentForBCNumber($modulus);

        return static::of($this->value->powmod($exponent, $modulus));
    }

    /**
     * @param int<1, 4> $roundingMode
     */
    public function pow(
        Number|BCNumber|string|int|float $exponent,
        int $minScale,
        int|null $scale = null,
        int $roundingMode = PHP_ROUND_HALF_UP,
    ): static {
        $exponent = $this->prepareArgumentForBCNumber($exponent);

        return static::of($this->value->pow($exponent, $minScale, $scale, $roundingMode));
    }

    /**
     * @param int<1, 4> $roundingMode
     */
    public function sqrt(int|null $scale = null, int $roundingMode = PHP_ROUND_HALF_UP): static
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

    public function comp(Number|BCNumber|string|int|float $num, int|null $scale = null): int
    {
        $num = $this->prepareArgumentForBCNumber($num);

        return $this->value->comp($num, $scale);
    }

    public function eq(Number|BCNumber|string|int|float $num, int|null $scale = null): bool
    {
        $num = $this->prepareArgumentForBCNumber($num);

        return $this->value->eq($num, $scale);
    }

    public function gt(Number|BCNumber|string|int|float $num, int|null $scale = null): bool
    {
        $num = $this->prepareArgumentForBCNumber($num);

        return $this->value->gt($num, $scale);
    }

    public function gte(Number|BCNumber|string|int|float $num, int|null $scale = null): bool
    {
        $num = $this->prepareArgumentForBCNumber($num);

        return $this->value->gte($num, $scale);
    }

    public function lt(Number|BCNumber|string|int|float $num, int|null $scale = null): bool
    {
        $num = $this->prepareArgumentForBCNumber($num);

        return $this->value->lt($num, $scale);
    }

    public function lte(Number|BCNumber|string|int|float $num, int|null $scale = null): bool
    {
        $num = $this->prepareArgumentForBCNumber($num);

        return $this->value->lte($num, $scale);
    }

    /**
     * @param int<1, 4> $roundingMode
     */
    public function format(
        int|null $scale = null,
        int $roundingMode = PHP_ROUND_HALF_UP,
        string $decimalSeparator = Number::DECIMAL_SEPARATOR,
        string $thousandsSeparator = Number::THOUSANDS_SEPARATOR,
    ): string {
        return $this->format($scale, $roundingMode, $decimalSeparator, $thousandsSeparator);
    }

    /**
     * Convert the given number to a type that is safe for BCMath\Number to use.
     *
     * Method signatures in Number support instances of Number and float, whereas BCMath\Number
     * only supports BCMath\Number, string and int.
     */
    protected function prepareArgumentForBCNumber(Number|BCNumber|string|int|float $num): BCNUmber|string|int
    {
        if (is_float($num)) {
            return static::of($num)->value;
        }

        if ($num instanceof Number) {
            return $num->value;
        }

        return $num;
    }
}
