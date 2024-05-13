<?php

declare(strict_types=1);

namespace Worksome\Number\Tests\Fixtures;

use ReflectionMethod;
use Worksome\Number\Number;

/**
 * Provides access to protected functions
 *
 * @method static array parseFragments(Number|string|int $num)
 *
 * @mixin Number
 */
class TestingNumber
{
    public function __construct(public readonly Number $value)
    {
    }

    public static function __callStatic($name, $arguments)
    {
        return (new ReflectionMethod(Number::class, $name))->invoke(null, ...$arguments);
    }

    public function __call($name, $arguments)
    {
        return (new ReflectionMethod($this->value, $name))->invoke($this->value, ...$arguments);
    }
}
