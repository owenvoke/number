<?php

declare(strict_types=1);

use Worksome\Number\Number;

test('Number wraps BCMath\Number', function () {
    $num = new Number(89753976423);

    expect($num->toString())->toBe('89753976423');
});
