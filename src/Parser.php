<?php

declare(strict_types=1);

namespace Worksome\Number;

use BCMath\Number as BCNumber;
use InvalidArgumentException;

class Parser
{
    public static function parseAsString(Number|BCNumber|string|int|float $num): string
    {
        return is_float($num) ? static::floatToString($num) : (string) $num;
    }

    /**
     * Parse the given number and extract the whole number.
     *
     * Example:
     *      "1.5534" => "1"
     *      "546.09" => "546"
     *      "892021" => "892021"
     */
    public static function parseWholeNumber(Number|BCNumber|string|int|float $num): string
    {
        $num = static::parseAsString($num);
        $pos = strpos($num, Number::DECIMAL_SYMBOL);

        return ($pos === false) ? $num : substr($num, 0, $pos);
    }

    /**
     * Parse the given number and extract the whole number.
     *
     * Example:
     *      "1.5534" => "5534"
     *      "546.09" => "09"
     *      "892021" => null
     */
    public static function parseDecimalNumber(Number|BCNumber|string|int|float $num): ?string
    {
        $num = static::parseAsString($num);
        $pos = strpos($num, Number::DECIMAL_SYMBOL);

        return ($pos === false) ? null : substr($num, $pos + 1);
    }

    /**
     * Convert the given float to its string form
     */
    public static function floatToString(float $number, null|int $precision = null): string
    {
        if ($precision === null) {
            $precision = (int) ini_get('precision');
        }

        if (! preg_match(
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
}
