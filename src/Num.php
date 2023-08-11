<?php

namespace Num;

use Num\DecimalSeparatorGuesser;

class Num
{
    /**
     * Decimal separator constants.
     */
    const POINT = '.';
    const COMMA = ',';
    
    /**
     * Convert a string to a float.
     */
    public static function float(string $value, ?string $decimalSeparator = null): float
    {
        $decimalSeparator = $decimalSeparator ?? self::guessDecimalSeparator($value);
        $cleanedValue = preg_replace('/[^\d' . preg_quote($decimalSeparator) . ']/', '', $value);

        if ($decimalSeparator === self::COMMA) {
            return (float) str_replace($decimalSeparator, self::POINT, $cleanedValue);
        }

        return (float) $cleanedValue;
    }

    /**
     * Convert a string to an integer.
     */
    public static function int(string $value, ?string $decimalSeparator = null): int
    {
        return (int) self::float($value, $decimalSeparator);
    }

    /**
     * Guess the decimal separator from a string representing a number.
     */
    public static function guessDecimalSeparator(string $value): string
    {
        return DecimalSeparatorGuesser::guess($value);
    }
}
