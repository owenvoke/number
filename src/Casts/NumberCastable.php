<?php

declare(strict_types=1);

namespace Worksome\Number\Casts;

use Illuminate\Contracts\Database\Eloquent\Castable;
use Worksome\Number\Number;

class NumberCastable implements Castable
{
    /**
     * Get the caster class to use when casting from / to this cast target.
     *
     * @param  array<int, class-string>  $arguments
     */
    public static function castUsing(array $arguments): NumberCast
    {
        /** @var class-string<Number> */
        $class = array_shift($arguments);

        return new NumberCast($class);
    }
}
