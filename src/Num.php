<?php

namespace Num;

use Num\Enums\DecimalSeparator;
use Num\DecimalSeparatorGuesser;

class Num
{
    // Converts a value to a float with optional decimal separator override
    public static function float(string|int|float $value, ?DecimalSeparator $decimalSeparator = null): float
    {
        return self::floatOrInt($value, $decimalSeparator, true);
    }

    // Converts a value to an int with optional decimal separator override
    public static function int(string|int|float $value, ?DecimalSeparator $decimalSeparator = null): int
    {
        return self::floatOrInt($value, $decimalSeparator);
    }

    // Handles conversion of value to float or int based on type and formatting
    private static function floatOrInt(string|int|float $value, ?DecimalSeparator $decimalSeparator = null, bool $returnFloat = false)
    {
        if (is_string($value)) {
            $cleanedValue = self::cleanValue($value, $decimalSeparator);

            $numericValue = $returnFloat ? (float) $cleanedValue : (int) $cleanedValue;

            return strpos($value, '-') === 0 ? -$numericValue : $numericValue;
        }

        if (is_numeric($value)) {
            return $returnFloat ? (float) $value : (int) $value;
        }

        throw new \InvalidArgumentException('The value must be either numeric or a string.');
    }

    // Guesses the decimal separator used in the value string
    public static function guessDecimalSeparator(string $value): DecimalSeparator
    {
        return DecimalSeparatorGuesser::guess($value);
    }

    // Cleans the value string by removing non-numeric characters and replacing decimal separator
    private static function cleanValue(string $value, ?DecimalSeparator $decimalSeparator = null): string
    {
        $decimalSeparator = $decimalSeparator ?? self::guessDecimalSeparator($value);

        $cleanedValue = preg_replace('/[^\d' . preg_quote($decimalSeparator->value) . ']/', '', $value);

        if ($decimalSeparator === DecimalSeparator::COMMA) {
            $cleanedValue = str_replace($decimalSeparator->value, DecimalSeparator::POINT->value, $cleanedValue);
        }

        return $cleanedValue;
    }
}
