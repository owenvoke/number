<?php

declare(strict_types=1);

namespace Worksome\Number;

use BCMath\Number as BCNumber;
use Illuminate\Support\Traits\Macroable;
use InvalidArgumentException;
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

    public const DECIMAL_SEPARATOR = '.';

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
            $value = static::floatToString($value);
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
     * Parse the given number and extract the whole number and decimal number
     *
     * @return array<int, string>
     */
    public static function parseFragments(Number|BCNumber|string|int|float $num): array
    {
        $num = (string) $num;
        $pos = strpos($num, self::DECIMAL_SEPARATOR);
        $wholeNumber = $num;
        $decimalNumber = '';

        if ($pos !== false) {
            $wholeNumber = substr($num, 0, $pos);
            $decimalNumber = substr($num, $pos + 1);
        }

        return [
            $wholeNumber,
            $decimalNumber,
        ];
    }

    /**
     * Convert the given float to its string form
     */
    protected static function floatToString(float $number, null|int $precision = null): string
    {
        if ($precision === null) {
            $precision = (int) ini_get('precision');
        }

        if (!preg_match(
            '/^(-?)(\d)\.(\d+)e([+-]\d+)$/',
            sprintf('%.' . ($precision - 1) . 'e', (float) $number),
            $match
        )) {
            throw new InvalidArgumentException(
                sprintf('Unable to convert "%s" into a string representation.', $number)
            );
        }

        $digits = rtrim($match[2] . $match[3], '0');
        $shift = (int) $match[4] + 1;

        return $match[1] . rtrim(
            (substr(str_pad($digits, $shift, '0'), 0, max(0, $shift)) ?: '0')
                . '.' . str_repeat('0', max(0, -$shift))
                . substr($digits, max(0, $shift)),
            '.'
        );
    }

    /**
     * Get the Laravel attribute castable for this Number
     */
    public static function cast(): string
    {
        return NumberCastable::class.':'.static::class;
    }
}
