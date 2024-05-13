<?php

namespace Worksome\Number\Exceptions;

use Exception;
use Worksome\Number\Number;

final class UnsafeTypeOutputException extends Exception implements NumberException
{
    public static function integer(Number $number): static
    {
        $message = sprintf(
            'Unsafe output of Number (%s) to integer (value is %s than %s)',
            $number->toString(),
            $number->isNegative() ? 'less' : 'greater',
            $number->isNegative() ? 'PHP_INT_MIN' : 'PHP_INT_MAX',
        );

        return new static($message);
    }

    public static function float(Number $number): static
    {
        $message = sprintf(
            'Unsafe output of Number (%s) to float (value is %s than %s)',
            $number->toString(),
            $number->isNegative() ? 'less' : 'greater',
            $number->isNegative() ? 'PHP_FLOAT_MIN' : 'PHP_FLOAT_MAX',
        );

        return new static($message);
    }
}
