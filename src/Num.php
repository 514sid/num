<?php

namespace Num;

use Num\Enums\DecimalSeparator;
use Num\DecimalSeparatorGuesser;

class Num
{
    /**
     * Convert a string to a float.
     */
    public static function float(string $value, ?DecimalSeparator $decimalSeparator = null): float
    {
        $decimalSeparator = $decimalSeparator ?? self::guessDecimalSeparator($value);
        $cleanedValue = preg_replace('/[^\d' . preg_quote($decimalSeparator->value) . ']/', '', $value);

        if ($decimalSeparator === DecimalSeparator::COMMA) {
            $cleanedValue = str_replace($decimalSeparator->value, DecimalSeparator::POINT->value, $cleanedValue);
        }

        $floatValue = (float) $cleanedValue;

        return strpos($value, '-') === 0 ? -$floatValue : $floatValue;
    }

    /**
     * Convert a string to an integer.
     */
    public static function int(string $value, ?DecimalSeparator $decimalSeparator = null): int
    {
        return (int) self::float($value, $decimalSeparator);
    }

    /**
     * Guess the decimal separator from a string representing a number.
     */
    public static function guessDecimalSeparator(string $value): DecimalSeparator
    {
        return DecimalSeparatorGuesser::guess($value);
    }
}
