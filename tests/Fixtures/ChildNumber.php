<?php

declare(strict_types=1);

namespace Worksome\Number\Tests\Fixtures;

use Worksome\Number\Number;

/**
 * Simulating a child number class
 */
class ChildNumber extends Number
{
    public function applyRandomPercentage(): static
    {
        return $this->mul(random_int(1, 100))->div(100);
    }
}
