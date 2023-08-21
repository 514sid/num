<?php

namespace Num\Tests;

use Num\Enums\DecimalSeparator;
use PHPUnit\Framework\TestCase;
use Num\DecimalSeparatorGuesser;

class DecimalSeparatorGuesserTest extends TestCase
{
    public static function decimalSeparatorProvider()
    {
        return [
            ['1,234,567.89',     DecimalSeparator::POINT],
            ['1,234,567',        DecimalSeparator::POINT],
            ['1 234 567.89',     DecimalSeparator::POINT],
            ['123,4567.89',      DecimalSeparator::POINT],
            ['1\'234\'567.89',   DecimalSeparator::POINT],
            ['123',              DecimalSeparator::POINT],
            ['text',             DecimalSeparator::POINT],
            ['12.34567',         DecimalSeparator::POINT],
            ['12,345',           DecimalSeparator::POINT],
            ['.12',              DecimalSeparator::POINT],
            ['12,3456',          DecimalSeparator::COMMA],
            ['1.234.567,89',     DecimalSeparator::COMMA],
            ['1 234 567,89',     DecimalSeparator::COMMA],
            ['1\'234\'567,89',   DecimalSeparator::COMMA],
            ['12,34567',         DecimalSeparator::COMMA],
            [',12',              DecimalSeparator::COMMA],
        ];
    }

    /**
     * @dataProvider decimalSeparatorProvider
     */
    public function testGuessingDecimalSeparatorFromNumberString($input, $expected)
    {
        $this->assertSame($expected, DecimalSeparatorGuesser::guess($input));
    }
}
