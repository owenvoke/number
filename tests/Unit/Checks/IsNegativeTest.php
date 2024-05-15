<?php

declare(strict_types=1);

use Worksome\Number\Number;

$isNegativeDataset = [
    ['-2343.03453', true],
    ['-324', true],
    ['-1', true],
    ['-0.000000000000001', true],
    ['0.000000000000001', false],
    ['1', false],
    ['324', false],
    ['2343.03453', false],
];

test('Number can check if it is negative', function (string $input, bool $expect) {
    $result = Number::of($input)->isNegative();

    expect($result)->toBe($expect);
})->with($isNegativeDataset + [
    '0' => false,
]);

test('Number can check if it is negative or zero', function (string $input, bool $expect) {
    $result = Number::of($input)->isNegativeOrZero();

    expect($result)->toBe($expect);
})->with($isNegativeDataset + [
    '0' => true,
]);
