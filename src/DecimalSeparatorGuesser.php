<?php

namespace Num;

use Num\NumberValidator;
use Num\Enums\DecimalSeparator;

class DecimalSeparatorGuesser
{
    /**
     * Guesses the appropriate decimal separator for the given numeric value.
     */
    public static function guess(string $value): DecimalSeparator
    {
        // Count occurrences of decimal point and comma in the value
        $pointCount = substr_count($value, DecimalSeparator::POINT->value);
        $commaCount = substr_count($value, DecimalSeparator::COMMA->value);

        // If there are no decimal points or commas, default to decimal point
        if ($pointCount === 0 && $commaCount === 0) {
            return DecimalSeparator::POINT;
        }

        // Check if the value can be treated as an integer
        $canBeInteger = NumberValidator::canBeInteger($value);

        // Determine the appropriate separator based on counts and integer check
        if ($pointCount > 0 && $commaCount === 0) {
            return self::selectDecimalSeparator(!$canBeInteger, DecimalSeparator::POINT, DecimalSeparator::COMMA);
        }

        if ($commaCount > 0 && $pointCount === 0) {
            return self::selectDecimalSeparator(!$canBeInteger, DecimalSeparator::COMMA, DecimalSeparator::POINT);
        }

        // Choose separator based on the last occurrence of each separator
        return self::selectDecimalSeparator(
            self::lastPosition($value, DecimalSeparator::POINT) > self::lastPosition($value, DecimalSeparator::COMMA),
            DecimalSeparator::POINT,
            DecimalSeparator::COMMA
        );
    }

    /**
     * Selects a decimal separator based on a condition.
     */
    private static function selectDecimalSeparator(bool $condition, DecimalSeparator $trueOption, DecimalSeparator $falseOption): DecimalSeparator
    {
        return $condition ? $trueOption : $falseOption;
    }

    /**
     * Returns the position of the last occurrence of a separator in the string.
     */
    private static function lastPosition(string $string, DecimalSeparator $separator): int
    {
        $lastPosition = strrpos($string, $separator->value);

        return $lastPosition !== false ? $lastPosition : -1;
    }
}
