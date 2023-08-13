<?php

namespace Num;

use Num\Enums\DecimalSeparator;

class NumberValidator
{
    public static function canBeInteger(string $input): bool
    {
        $cleanedInput = preg_replace("/[^\d,.]/", "", $input);

        $dotCount = substr_count($cleanedInput, DecimalSeparator::POINT->value);
        $commaCount = substr_count($cleanedInput, DecimalSeparator::COMMA->value);

        if ($dotCount + $commaCount === 1) {
            $separatorPosition = $dotCount === 1 ? strpos($cleanedInput, DecimalSeparator::POINT->value) : strpos($cleanedInput, DecimalSeparator::COMMA->value);

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
