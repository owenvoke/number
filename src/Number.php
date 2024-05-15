<?php

declare(strict_types=1);

namespace Worksome\Number;

use BCMath\Number as BCNumber;
use Illuminate\Support\Traits\Macroable;
use Stringable;
use Worksome\Number\Casts\NumberCastable;

class Number implements Stringable
{
    use Macroable;
    use Traits\HasChecks;
    use Traits\HasCleaning;
    use Traits\HasModifications;
    use Traits\HasOutputTo;
    use Traits\HasRandom;
    use Traits\HasShortcuts;
    use Traits\HasStatistics;
    use Traits\ProxiesToNumber;

    public const NEGATIVE_SYMBOL = '-';

    public const DECIMAL_SYMBOL = '.';

    public const THOUSANDS_SEPARATOR = '';

    public BCNumber $value;

    public function __construct(
        Number|BCNumber|string|int|float $value,
    ) {
        $this->value = new BCNumber((string) $value);

        $this->validate();
    }

    /**
     * Immediately validate the number instance.
     */
    protected function validate(): void
    {
    }

    /**
     * Parse the given number
     */
    public static function of(Number|BCNumber|string|int|float $value): static
    {
        if (is_float($value)) {
            $value = (string) $value;
        }

        /** @phpstan-ignore-next-line */
        return new static($value);
    }

    /**
     * Get the scale (precision length) of this number
     */
    public function getScale(): int
    {
        return $this->value->scale;
    }

    /** @TODO: This should be moved to a money package. */
    public function inCents(): int
    {
        return $this->mul(100)->toInteger();
    }

    /**
     * Get the Laravel attribute castable for this Number
     */
    public static function cast(): string
    {
        return NumberCastable::class . ':' . static::class;
    }
}
