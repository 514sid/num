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
        $pointCount = substr_count($value, self::POINT);
        $commaCount = substr_count($value, self::COMMA);

        if ($pointCount === 0 && $commaCount === 0) {
            return self::POINT;
        }

        $canBeInteger = self::canBeInteger($value);

        if ($pointCount > 0 && $commaCount === 0) {
            if (!$canBeInteger && $pointCount === 1) {
                return self::POINT;
            }
            
            if ($canBeInteger && $pointCount === 1) {
                return self::COMMA;
            }
            
            return ($pointCount > 1) ? self::COMMA : self::POINT;
        }

        if ($commaCount > 0 && $pointCount === 0) {
            if (!$canBeInteger && $commaCount === 1) {
                return self::COMMA;
            }
            
            if ($canBeInteger && $commaCount === 1) {
                return self::POINT;
            }
            
            return ($commaCount > 1) ? self::POINT : self::COMMA;
        }

        if ($pointCount < $commaCount) {
            return self::POINT;
        } elseif ($commaCount < $pointCount) {
            return self::COMMA;
        } else {
            $lastPointPosition = strrpos($value, self::POINT);
            $lastCommaPosition = strrpos($value, self::COMMA);

            if ($lastPointPosition !== false && $lastCommaPosition !== false) {
                return ($lastPointPosition > $lastCommaPosition) ? self::POINT : self::COMMA;
            } elseif ($lastPointPosition !== false) {
                return self::POINT;
            } elseif ($lastCommaPosition !== false) {
                return self::COMMA;
            }
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

            $pos = (($dotCount === 1) ? $dotPosition : $commaPosition) + 1;
            $digitsAfterSeparator = substr($cleanedInput, $pos);
    
            $digitCount = strlen($digitsAfterSeparator);
    
            if ($digitCount !== 3) {
                return false;
            }
        }
    
        return true;
    }
}
