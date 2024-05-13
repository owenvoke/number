<?php

declare(strict_types=1);

use Worksome\Number\Number;

test('Number can create numbers using shortcuts', function (string $method, string $expect) {
    /** @var Number $result */
    $result = Number::{$method}();

    expect($result->value->value)->toBe($expect);
})->with([
    ['pi', Number::PI],
    ['e', Number::E],
    ['zero', Number::ZERO],
    ['one', Number::ONE],
]);
