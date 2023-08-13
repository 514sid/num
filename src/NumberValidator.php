<?php

namespace Num;

class NumberValidator
{
    const POINT = '.';
    const COMMA = ',';

    public static function canBeInteger(string $input): bool
    {
        $cleanedInput = preg_replace("/[^\d,.]/", "", $input);

        $dotCount = substr_count($cleanedInput, self::POINT);
        $commaCount = substr_count($cleanedInput, self::COMMA);

        if ($dotCount + $commaCount === 1) {
            $separatorPosition = $dotCount === 1 ? strpos($cleanedInput, self::POINT) : strpos($cleanedInput, self::COMMA);

            if ($separatorPosition > 3) {
                return false;
            }

            if (strlen(substr($cleanedInput, $separatorPosition + 1)) !== 3) {
                return false;
            }
        }

        return true;
    }
}