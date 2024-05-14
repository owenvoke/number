<?php

use Worksome\Number\Casts\NumberCast;
use Worksome\Number\Casts\NumberCastable;
use Worksome\Number\Number;
use Worksome\Number\Tests\Fixtures\ChildNumber;

test('Number can define a castable based on the number calling class', function () {
    expect(Number::cast())->toBe(NumberCastable::class . ':' . Number::class);
    expect(ChildNumber::cast())->toBe(NumberCastable::class . ':' . ChildNumber::class);
});

test('NumberCastable can resolve a CastsAttributes specific to that class', function () {
    /** @var NumberCast $castable */
    $castable = NumberCastable::castUsing([ Number::class ]);

    expect($castable)
        ->toBeInstanceOf(NumberCast::class)
        ->and($castable->class)
        ->toBe(Number::class);

    /** @var NumberCast $castable */
    $castable = NumberCastable::castUsing([ ChildNumber::class ]);

    expect($castable)
    ->toBeInstanceOf(NumberCast::class)
    ->and($castable->class)
    ->toBe(ChildNumber::class);
});
