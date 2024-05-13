<?php

declare(strict_types=1);

namespace Worksome\Number\Traits;

use BCMath\Number as BCNumber;
use Worksome\Number\Exceptions\AtLeastOneNumberRequiredException;
use Worksome\Number\Number;

/**
 * @mixin Number
 */
trait HasStatistics
{
    public static function sum(Number|BCNumber|string|int|float ...$numbers): static
    {
        /** Check if not `isset` (not if `empty` due to zero being valid), and throw exception if not set */
        if (!isset($numbers[0])) {
            throw AtLeastOneNumberRequiredException::method(__FUNCTION__);
        }

        /** @var static $total */
        $total = array_reduce(
            $numbers,
            fn (Number $total, Number|BCNumber|string|int|float $num) => $total->add($num),
            static::zero()
        );

        return $total;
    }

    public static function maxScale(Number|BCNumber|string|int|float ...$numbers): int
    {
        /** Check if not `isset` (not if `empty` due to zero being valid), and throw exception if not set */
        if (!isset($numbers[0])) {
            throw AtLeastOneNumberRequiredException::method(__FUNCTION__);
        }

        /** @var int $max */
        $max = array_reduce(
            $numbers,
            fn (int $max, Number|BCNumber|string|int|float $num) => (int) max(
                $max,
                static::of($num)->getScale()
            ), /** @phpstan-ignore-line */
            0,
        );

        return $max;
    }

    public static function minScale(Number|BCNumber|string|int|float ...$numbers): int
    {
        /** Check if not `isset` (not if `empty` due to zero being valid), and throw exception if not set */
        if (!isset($numbers[0])) {
            throw AtLeastOneNumberRequiredException::method(__FUNCTION__);
        }

        /** @var ?int $min */
        $min = array_reduce(
            $numbers,
            fn (?int $min, Number|BCNumber|string|int|float $num) => (int) min(
                $min ?? INF,
                static::of($num)->getScale()
            ), /** @phpstan-ignore-line */
            null,
        );

        return $min === null ? 0 : $min;
    }

    public static function mean(Number|BCNumber|string|int|float ...$numbers): static
    {
        /** Check if not `isset` (not if `empty` due to zero being valid), and throw exception if not set */
        if (!isset($numbers[0])) {
            throw AtLeastOneNumberRequiredException::method(__FUNCTION__);
        }

        $scale = static::maxScale(...$numbers);

        $count = count($numbers);
        $sum = static::sum(...$numbers);

        return $sum->div($count)->clean($scale);
    }

    public static function median(Number|BCNumber|string|int|float ...$numbers): static
    {
        /** Check if not `isset` (not if `empty` due to zero being valid), and throw exception if not set */
        if (!isset($numbers[0])) {
            throw AtLeastOneNumberRequiredException::method(__FUNCTION__);
        }

        /** Standardise */
        $numbers = array_map(
            fn (Number|BCNumber|string|int|float $num) => static::of($num)->value,
            $numbers,
        );

        /** Sort natural order */
        natsort($numbers);
        $numbers = array_values($numbers);

        /**
         * Find middle
         */
        $count = count($numbers);
        $middle = floor($count / 2);

        if ($count % 2 === 1) {
            return static::of($numbers[$middle]);
        }

        return static::of($numbers[$middle - 1])->add($numbers[$middle])->div(2);
    }

    public static function minimum(Number|BCNumber|string|int|float ...$numbers): static
    {
        /** Check if not `isset` (not if `empty` due to zero being valid), and throw exception if not set */
        if (!isset($numbers[0])) {
            throw AtLeastOneNumberRequiredException::method(__FUNCTION__);
        }

        $start = static::of(array_pop($numbers));

        /** @var static $min */
        $min = array_reduce(
            $numbers,
            fn (Number $min, Number|BCNumber|string|int|float $num) => $min->min($num),
            $start,
        );

        return $min;
    }

    public static function maximum(Number|BCNumber|string|int|float ...$numbers): static
    {
        /** Check if not `isset` (not if `empty` due to zero being valid), and throw exception if not set */
        if (!isset($numbers[0])) {
            throw AtLeastOneNumberRequiredException::method(__FUNCTION__);
        }

        $start = static::of(array_pop($numbers));

        /** @var static $max */
        $max = array_reduce(
            $numbers,
            fn (Number $min, Number|BCNumber|string|int|float $num) => $min->max($num),
            $start,
        );

        return $max;
    }

    public function min(Number|BCNumber|string|int|float $num): static
    {
        return $this->lt($num) ? $this : static::of($num);
    }

    public function max(Number|BCNumber|string|int|float $num): static
    {
        return $this->gt($num) ? $this : static::of($num);
    }
}
