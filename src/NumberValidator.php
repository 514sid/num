<?php

namespace Num;

use Num\Enums\DecimalSeparator;

class NumberValidator
{
	const INTEGER_MAX_DIGITS_BEFORE_SEPARATOR = 3;
    const INTEGER_REQUIRED_DIGITS_AFTER_SEPARATOR = 3;

    public static function canBeInteger(string $input): bool
    {
        $cleanedInput = self::cleanInput($input);

        $separatorCounts = self::countSeparators($cleanedInput);

        if (!self::hasExactlyOneSeparator($separatorCounts)) {
            return true;
        }

        $separatorPosition = self::findSeparatorPosition($cleanedInput, $separatorCounts);

        return self::hasValidAmountOfDigitsBeforeSeparator($separatorPosition) && self::hasValidAmountOfDigitsAfterSeparator($cleanedInput, $separatorPosition);
    }

    private static function cleanInput(string $input): string
    {
        $input = preg_replace("/[^\d,.]/", "", $input);

        return ltrim($input, '0');
    }

    private static function hasExactlyOneSeparator(array $separatorCounts): bool
    {
        return $separatorCounts['pointCount'] + $separatorCounts['commaCount'] === 1;
    }

    private static function countSeparators(string $input): array
    {
        $pointCount = substr_count($input, DecimalSeparator::POINT->value);
        $commaCount = substr_count($input, DecimalSeparator::COMMA->value);

        return ['pointCount' => $pointCount, 'commaCount' => $commaCount];
    }

    private static function findSeparatorPosition(string $input, array $separatorCounts): int
    {
        return $separatorCounts['pointCount'] === 1 ?
            strpos($input, DecimalSeparator::POINT->value) :
            strpos($input, DecimalSeparator::COMMA->value);
    }

    private static function hasValidAmountOfDigitsBeforeSeparator(int $separatorPosition): bool
    {
        return $separatorPosition > 0 && $separatorPosition <= self::INTEGER_MAX_DIGITS_BEFORE_SEPARATOR;
    }

    private static function hasValidAmountOfDigitsAfterSeparator(string $input, int $separatorPosition): bool
    {
        $decimalPart = substr($input, $separatorPosition + 1);
        return strlen($decimalPart) === self::INTEGER_REQUIRED_DIGITS_AFTER_SEPARATOR;
    }
}
