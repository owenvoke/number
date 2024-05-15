<?php

declare(strict_types=1);

use Worksome\Number\Number;

test('Number can truncate superfluous precision', function (string $input, string $expect) {
    $result = Number::of($input)->truncate();

    expect($result->value->value)->toBe($expect);
})->with([
    ['1.0', '1'],
    ['1.0000', '1'],
    ['1.1', '1.1'],
    ['1.000000001', '1.000000001'],
    ['-1.000000001', '-1.000000001'],
    ['-1.000000000', '-1'],
]);
