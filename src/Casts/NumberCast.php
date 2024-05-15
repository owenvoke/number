<?php

declare(strict_types=1);

namespace Worksome\Number\Casts;

use BCMath\Number as BCNumber;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Worksome\Number\Number;

/**
 * @property class-string<Number> $class
 *
 * @implements CastsAttributes<Number, Number>
 */
class NumberCast implements CastsAttributes
{
    /**
     * @param class-string<Number> $class
     */
    public function __construct(public string $class = Number::class)
    {
    }

    /**
     * @param int|float|string $value
     */
    public function get($model, string $key, $value, array $attributes): Number
    {
        $class = $this->class;

        return $class::of($value);
    }

    /**
     * @param Number|BCNumber|string|int|float|null $value
     */
    public function set($model, string $key, $value, array $attributes): null|string
    {
        $class = $this->class;

        return $value === null ? null : $class::of($value)->toString();
    }
}
