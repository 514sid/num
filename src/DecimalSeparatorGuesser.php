<?php

namespace Num;

use Num\NumberValidator;

class DecimalSeparatorGuesser
{
    const POINT = '.';
    const COMMA = ',';

    /**
     * Guesses the appropriate decimal separator for the given numeric value.
     */
    public static function guess(string $value): string
    {
        // Count occurrences of decimal point and comma in the value
        $pointCount = substr_count($value, self::POINT);
        $commaCount = substr_count($value, self::COMMA);

        // If there are no decimal points or commas, default to decimal point
        if ($pointCount === 0 && $commaCount === 0) {
            return self::POINT;
        }

        // Check if the value can be treated as an integer
        $canBeInteger = NumberValidator::canBeInteger($value);

        // Determine the appropriate separator based on counts and integer check
        if ($pointCount > 0 && $commaCount === 0) {
            return self::selectDecimalSeparator(!$canBeInteger, self::POINT, self::COMMA);
        }

        if ($commaCount > 0 && $pointCount === 0) {
            return self::selectDecimalSeparator(!$canBeInteger, self::COMMA, self::POINT);
        }

        // If commas are fewer than points, use comma as separator
        if ($commaCount < $pointCount) {
            return self::COMMA;
        }

        // Choose separator based on the last occurrence of each separator
        return self::selectDecimalSeparator(
            self::lastPosition($value, self::POINT) > self::lastPosition($value, self::COMMA),
            self::POINT,
            self::COMMA
        );
    }

    /**
     * Selects a decimal separator based on a condition.
     */
    private static function selectDecimalSeparator(bool $condition, string $trueOption, string $falseOption): string
    {
        return $condition ? $trueOption : $falseOption;
    }

    /**
     * Returns the position of the last occurrence of a separator in the string.
     */
    private static function lastPosition(string $string, string $separator): int
    {
        $lastPosition = strrpos($string, $separator);

        return $lastPosition !== false ? $lastPosition : -1;
    }
}
