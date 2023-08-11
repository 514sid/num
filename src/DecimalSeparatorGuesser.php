<?php

namespace Num;

use Num\NumberValidator;

class DecimalSeparatorGuesser
{
    const POINT = '.';
    const COMMA = ',';

    public static function guess(string $value): string
    {
        $pointCount = substr_count($value, self::POINT);
        $commaCount = substr_count($value, self::COMMA);

        $hasComma = $commaCount > 0;
        $hasPoint = $pointCount > 0;

        if (!$hasComma && !$hasPoint) {
            return self::POINT;
        }

        $canBeInteger = NumberValidator::canBeInteger($value);

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
}
