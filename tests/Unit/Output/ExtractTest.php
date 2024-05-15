<?php

use Worksome\Number\Number;

dataset('extract_numbers', [
    ['12', '12', '0'],
    ['12.34', '12', '34'],
    ['435435.345346345', '435435', '345346345'],
    ['9.8', '9', '8'],
    ['-32423.0', '-32423', '0'],
    ['938457475983475938475938.239921847392740236589345349', '938457475983475938475938', '239921847392740236589345349'],
    ['0.0', '0', '0'],
]);

test('Number can extract the integer portion', function (string $input, string $whole, string $decimal) {
    $result = Number::of($input)->extractInteger()->toString();

    expect($result)->toBe($whole);
})->with('extract_numbers');

test('Number can extract the decimal portion', function (string $input, string $whole, string $decimal) {
    $result = Number::of($input)->extractDecimal()->toString();

    expect($result)->toBe($decimal);
})->with('extract_numbers');
