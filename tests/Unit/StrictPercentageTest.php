<?php

declare(strict_types=1);

use Pest\Expectation;
use Worksome\Number\Exceptions\InvalidValueException;
use Worksome\Number\StrictPercentage;

it(
    'throws an exception when an invalid percentage is provided',
    function (string|int|float|StrictPercentage $value) {
        /** @var Expectation $expectation */
        StrictPercentage::of($value);
    }
)->with([
    'too large (string)' => '101',
    'too small (string)' => '-1',
    'too large (int)' => 101,
    'too small (int)' => -1,
    'too large (float)' => 101.1,
    'too small (float)' => -1.1,
])->throws(InvalidValueException::class);

it('is immutable', function () {
    $number = StrictPercentage::of('20');
    expect($number->eq(20))->toBeTrue();

    $number->add(StrictPercentage::of(2));
    expect($number->eq(20))->toBeTrue();

    $number->sub(StrictPercentage::of(3));
    expect($number->eq(20))->toBeTrue();

    $number->mul(StrictPercentage::of(4));
    expect($number->eq(20))->toBeTrue();

    $number->div(StrictPercentage::of(5));
    expect($number->eq(20))->toBeTrue();
});

it('can get underlying value as string', function (string|float $number, string $result) {
    expect(StrictPercentage::of($number)->toString())->toEqual($result);
})->with([
    'integers as strings' => ['10', '10%'],
    'integers' => [2, '2%'],
    'floats as strings' => ['0.002', '0.002%'],
    'floats' => [0.002, '0.002%'],
    'large floats as strings' => ['1.1000000001', '1.1000000001%'],
]);
