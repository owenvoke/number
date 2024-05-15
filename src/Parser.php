<?php

declare(strict_types=1);

namespace Worksome\Number;

use BCMath\Number as BCNumber;
use InvalidArgumentException;

class Parser
{
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
        $num = (string) $num;
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
        $num = (string) $num;
        $pos = strpos($num, Number::DECIMAL_SYMBOL);

        return ($pos === false) ? null : substr($num, $pos + 1);
    }
}
