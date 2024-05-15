<?php

use Worksome\Number\Number;

test('Number can convert to integer', function (string $input) {
    $expect = (int) $input;
    $result = Number::of($input)->toInteger();

    expect($result)->toBe($expect);
})->with([
    '3234.23423423',
    '-3234.23423423',
    '23.000',
    '-23.000',
    '10.000',
    '-10.000',
    '0.0',
    '0',
    '23',
    '-23',
    '32423794237034',
    '-32423794237034',
    '239472374',
    '-239472374',
]);
