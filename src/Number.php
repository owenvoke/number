<?php

declare(strict_types=1);

namespace Worksome\Number;

use BCMath\Number as BCNumber;
use Illuminate\Support\Traits\Macroable;
use Stringable;

class Number implements Stringable
{
    use Macroable;
    use Traits\HasChecks;
    use Traits\HasCleaning;
    use Traits\HasHelpers;
    use Traits\HasModifications;
    use Traits\HasOutputTo;
    use Traits\HasRandom;
    use Traits\HasShortcuts;
    use Traits\HasStatistics;
    use Traits\ProxiesToNumber;

    public const NEGATIVE_SYMBOL = '-';

    public const DECIMAL_SEPARATOR = '.';

    public const THOUSANDS_SEPARATOR = '';

    public const ZERO = '0';

    public const ONE = '1';

    public const TEN = '10';

    public BCNumber $value;

    public function __construct(
        Number|BCNumber|string|int|float $value,
    ) {
        $this->value = new BCNumber((string) $value);

        $this->validate();
    }

    public static function of(Number|BCNumber|string|int|float $value): static
    {
        if (is_float($value)) {
            $value = (string) $value;
        }

        /** @phpstan-ignore-next-line */
        return new static($value);
    }

    public function getScale(): int
    {
        return $this->value->scale;
    }

    public function percentage(Number|BCNumber|string|int|float $number): Number
    {
        return $this->div(100)->mul($number);
    }

    /** @TODO: This should be moved to a money package. */
    public function inCents(): int
    {
        return $this->mul(100)->toInteger();
    }

    protected function validate(): void
    {
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
}
