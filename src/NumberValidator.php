<?php

namespace Num;

class NumberValidator
{
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
        $pointCount = substr_count($input, '.');
        $commaCount = substr_count($input, ',');

        return ['pointCount' => $pointCount, 'commaCount' => $commaCount];
    }

    private static function findSeparatorPosition(string $input, array $separatorCounts): int
    {
        return $separatorCounts['pointCount'] === 1 ?
            strpos($input, '.') :
            strpos($input, ',');
    }

    private static function hasValidAmountOfDigitsBeforeSeparator(int $separatorPosition): bool
    {
        return $separatorPosition > 0 && $separatorPosition <= 3;
    }

    private static function hasValidAmountOfDigitsAfterSeparator(string $input, int $separatorPosition): bool
    {
        $decimalPart = substr($input, $separatorPosition + 1);
        return strlen($decimalPart) === 3;
    }
}
