<?php

namespace Num;

use Num\Enums\DecimalSeparator;

class NonNumericFilter
{
    public static function sanitize(string|int|float $value, ?DecimalSeparator $decimalSeparator = null): int|float
    {
        if (is_string($value)) {
            $decimalSeparator = $decimalSeparator ?? DecimalSeparatorGuesser::guess($value);
            $cleanedValue = preg_replace('/[^\d' . preg_quote($decimalSeparator->value) . ']/', '', $value);

            if ($decimalSeparator === DecimalSeparator::COMMA) {
                $cleanedValue = str_replace($decimalSeparator->value, DecimalSeparator::POINT->value, $cleanedValue);
            }

            $float = (float) $cleanedValue;

            return self::isNegative($value) ? -$float : $float;
        }

        if (is_numeric($value)) {
            return $value;
        }

        throw new \InvalidArgumentException('The value must be either numeric or a string.');
    }

    private static function isNegative($value): bool
    {
        if (is_string($value) && strpos($value, '-') === 0) {
            return true;
        }
        return false;
    }
}
