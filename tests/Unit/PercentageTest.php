<?php

declare(strict_types=1);

use Worksome\Number\Percentage;

it('is immutable', function () {
    $number = Percentage::of('9');
    expect($number->eq(9))->toBeTrue();

    $number->add(Percentage::of(2));
    expect($number->eq(9))->toBeTrue();

    $number->sub(Percentage::of(3));
    expect($number->eq(9))->toBeTrue();

    $number->mul(Percentage::of(4));
    expect($number->eq(9))->toBeTrue();

    $number->div(Percentage::of(5));
    expect($number->eq(9))->toBeTrue();
});

it('can get underlying value as string', function (string|float $number, string $result) {
    expect(Percentage::of($number)->toString())->toEqual($result);
})->with([
    'integers as strings' => ['10', '10%'],
    'integers' => [2, '2%'],
    'floats as strings' => ['0.002', '0.002%'],
    'floats' => [0.002, '0.002%'],
    'large floats as strings' => ['1000000001.1000000001', '1000000001.1000000001%'],
]);
