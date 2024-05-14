<?php

use Worksome\Number\Casts\NumberCast;
use Worksome\Number\Number;
use Worksome\Number\Tests\Fixtures\ChildNumber;
use Worksome\Number\Tests\Fixtures\TestingModel;

dataset('number_cast_dataset', [
    '4',
    '2395734759834759843759834',
    '88352912129878935593583495628745729517476823.983495734957310374343',
    '1.000000000',
    '1.000000001',
    '0.999999999',
    [3249872394, '3249872394'],
    [9223372036854775807, '9223372036854775807'],
    '2093562907457029374332',
]);

test('NumberCast can cast attributes via get', function (string|float|int $databaseValue, null|string $stringValue = null) {
    $cast = new NumberCast();
    /** @var Number $result */
    $result = $cast->get(new TestingModel(), 'amount', $databaseValue, []);
    expect($result)->toBeInstanceOf(Number::class)
        ->not->toBeInstanceOf(ChildNumber::class);
    expect($result->eq(Number::of($databaseValue)));

    /**
     * Try again with a different Number class
     */

    $cast = new NumberCast(ChildNumber::class);
    /** @var Number $result */
    $result = $cast->get(new TestingModel(), 'amount', $databaseValue, []);
    expect($result)->toBeInstanceOf(ChildNumber::class);
    expect($result->eq(ChildNumber::of($databaseValue)));
})->with('number_cast_dataset');

test('NumberCast can cast attributes via set', function (string|float|int $databaseValue, null|string $stringValue = null) {
    $stringValue ??= (string) $databaseValue;

    $cast = new NumberCast();
    /** @var Number $result */
    $result = $cast->set(new TestingModel(), 'amount', Number::of($databaseValue), []);
    expect($result)->toBe($stringValue);

    /**
     * Try again with a different Number class
     */

    $cast = new NumberCast(ChildNumber::class);
    /** @var Number $result */
    $result = $cast->set(new TestingModel(), 'amount', ChildNumber::of($databaseValue), []);
    expect($result)->toBe($stringValue);
})->with('number_cast_dataset');
