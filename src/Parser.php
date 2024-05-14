<?php

declare(strict_types=1);

namespace Worksome\Number;

use BCMath\Number as BCNumber;
use InvalidArgumentException;

class Parser
{
    /**
     * Parse the given number and extract the whole number and decimal number
     *
     * @return array<int, string>
     */
    public static function parseFragments(Number|BCNumber|string|int|float $num): array
    {
        $num = (string) $num;
        $pos = strpos($num, Number::DECIMAL_SYMBOL);
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
    public static function floatToString(float $number, null|int $precision = null): string
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
}
