<?php

namespace Num;

use Num\NonNumericFilter;
use Num\DecimalSeparatorGuesser;

class Num
{
    public static function float(float|int|string|null $value, ?string $decimalSeparator = null): float
    {
        if ($value === null) {
            return 0.00;
        }

        return (float) NonNumericFilter::sanitize($value, $decimalSeparator);
    }

    public static function int(float|int|string|null $value, ?string $decimalSeparator = null): int
    {
        if ($value === null) {
            return 0;
        }

        return (int) NonNumericFilter::sanitize($value, $decimalSeparator);
    }

    public static function guessDecimalSeparator(string $value): string
    {
        return DecimalSeparatorGuesser::guess($value);
    }
}
