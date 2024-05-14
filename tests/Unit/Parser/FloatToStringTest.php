<?php

use Worksome\Number\Parser;

test('floats can be converted to string', function (float $input, string $expect) {
    $result = Parser::floatToString($input);

    expect($result)->toBe($expect);
})->with([
    [-1.0, '-1'],
    [0.0, '0'],
    [1.0, '1'],
    [1.2, '1.2'],
    [1.03, '1.03'],
    [1.004, '1.004'],
    [9834.239472, '9834.239472'],
    [
        PHP_FLOAT_MAX,
        '179769313486230000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000'
    ],
    [
        PHP_FLOAT_MIN,
        '0.000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000022250738585072'
    ],
    [
        -PHP_FLOAT_MAX,
        '-179769313486230000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000'
    ],
    [
        -PHP_FLOAT_MIN,
        '-0.000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000022250738585072'
    ],
]);
