<?php

namespace Num;

use Num\NonNumericFilter;
use Num\Enums\DecimalSeparator;
use Num\DecimalSeparatorGuesser;

class Num
{
    public static function float(float|int|string $value, ?DecimalSeparator $decimalSeparator = null): float
    {
        return (float) NonNumericFilter::sanitize($value, $decimalSeparator);
    }

    public static function int(float|int|string $value, ?DecimalSeparator $decimalSeparator = null): int
    {
        return (int) NonNumericFilter::sanitize($value, $decimalSeparator);
    }

    public static function guessDecimalSeparator(string $value): DecimalSeparator
    {
        return DecimalSeparatorGuesser::guess($value);
    }
}
