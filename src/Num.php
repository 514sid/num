<?php

namespace Num;

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
        $cleanedValue = preg_replace('/[^0-9' . preg_quote($decimalSeparator) . ']/', '', $value);

        if ($decimalSeparator === self::COMMA) {
            $floatValue = (float) str_replace($decimalSeparator, self::POINT, $cleanedValue);
        } else {
            $floatValue = (float) $cleanedValue;
        }

        return $floatValue;
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
        $pointCount = substr_count($value, self::POINT);
        $commaCount = substr_count($value, self::COMMA);

        $hasComma = $commaCount > 0;
        $hasPoint = $pointCount > 0;

        if (!$hasComma && !$hasPoint) {
            return self::POINT;
        }

        $canBeInteger = self::canBeInteger($value);

        if ($pointCount > 0 && $commaCount == 0) {
            return (!$canBeInteger) ? self::POINT : self::COMMA;
        }

        if ($commaCount > 0 && $pointCount == 0) {
            return (!$canBeInteger) ? self::COMMA : self::POINT;
        }

        if ($commaCount < $pointCount) {
            return self::COMMA;
        }

        $lastPointPosition = strrpos($value, self::POINT);
        $lastCommaPosition = strrpos($value, self::COMMA);

        if ($lastPointPosition !== false && $lastCommaPosition !== false) {
            return ($lastPointPosition > $lastCommaPosition) ? self::POINT : self::COMMA;
        } elseif ($lastCommaPosition !== false) {
            return self::COMMA;
        }

        return self::POINT;
    }

    public static function canBeInteger($input): bool
    {
        $cleanedInput = preg_replace("/[^0-9,.]/", "", $input);

        $dotCount = substr_count($cleanedInput, ".");
        $commaCount = substr_count($cleanedInput, ",");

        if ($dotCount + $commaCount === 1) {
            $dotPosition = strpos($cleanedInput, ".");
            $commaPosition = strpos($cleanedInput, ",");

            if ($dotCount === 1) {
                $digitsAfterSeparator = substr($cleanedInput, $dotPosition + 1);
            } else {
                $digitsAfterSeparator = substr($cleanedInput, $commaPosition + 1);
            }

            $digitCount = strlen($digitsAfterSeparator);

            if ($digitCount !== 3) {
                return false;
            }
        }

        return true;
    }
}
