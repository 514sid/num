<?php

namespace Num;

use Num\Enums\DecimalSeparator;

class NonNumericFilter
{
    public static function sanitize(string|int|float $value, ?DecimalSeparator $decimalSeparator = null): int|float
    {
        if (is_string($value)) {
			$value = trim($value);

			$decimalSeparator = $decimalSeparator ?? DecimalSeparatorGuesser::guess($value);

			if (strpos($value, 'e') !== false) {
				return self::handleScientificNotation($value);
			}

			$cleanedValue = preg_replace('/[^\d' . preg_quote($decimalSeparator->value) . ']/', '', $value);

			if ($decimalSeparator === DecimalSeparator::COMMA) {
				$cleanedValue = str_replace($decimalSeparator->value, DecimalSeparator::POINT->value, $cleanedValue);
			}

			$floatValue = (float) $cleanedValue;

			return self::isNegative($value) ? -$floatValue : $floatValue;
		}

		if (is_numeric($value)) {
			return $value;
		}

        throw new \InvalidArgumentException('The value must be either numeric or a string.');
    }

    private static function isNegative(string $value): bool
	{
		return strpos($value, '-') === 0;
	}

	private static function handleScientificNotation(string $value): float
	{
		list($coefficient, $exponent) = explode('e', $value);
		return (float) $coefficient * (float) pow(10, (int) $exponent);
	}
}
