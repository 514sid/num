<?php

namespace Num\Tests;

use Num\Num;
use Num\Enums\DecimalSeparator;
use PHPUnit\Framework\TestCase;

class NumTest extends TestCase
{
    public static function conversionData(): array
    {
        return [
            'Guesser' => [
                'testCases' => [
                    ['123',         123.0,      123],
                    ['-123',        -123.0,     -123],
                    ['12.34567',    12.34567,   12],
                    ['12.34',       12.34,      12],
                    ['12.345',      12345.0,    12345],
                    ['-12.345',     -12345.0,   -12345],
                    ['text',        0.0,        0],
                    ['.12',         0.12,       0],
                    [123.45,        123.45,     123],
                    [123,           123.0,      123],
                ],
                'separator' => null,
            ],

            'Point Separator' => [
                'testCases' => [
                    ['123',             123.0,          123],
                    ['1,234,567.89',    1234567.89,     1234567],
                    ['1,234,567',       1234567.0,      1234567],
                    ['1 234 567.89',    1234567.89,     1234567],
                    ['123,4567.89',     1234567.89,     1234567],
                    ['1\'234\'567.89',  1234567.89,     1234567],
                    ['-1\'234\'567.89', -1234567.89,    -1234567],
                    ['12,345',          12345.0,        12345],
                    ['12,3456',         123456.0,       123456],
                    ['3.14159265359',   3.14159265359,  3],
                    ['$12.30',          12.30,          12],
                    ['-12.30',          -12.30,         -12],
                    ['text',            0.0,            0],
                    ['.12',             0.12,           0],
                    ['-123.45',         -123.45,        -123],
                    [123,               123.0,          123],
                ],
                'separator' => DecimalSeparator::POINT,
            ],

            'Comma Separator' => [
                'testCases' => [
                    ['123',             123.0,          123],
                    ['1 234 567,89',    1234567.89,     1234567],
                    ['1.234.567,89',    1234567.89,     1234567],
                    ['1\'234\'567,89',  1234567.89,     1234567],
                    ['12,345',          12.345,         12],
                    ['-12,345',         -12.345,        -12],
                    ['3,14159265359',   3.14159265359,  3],
                    ['12.34567',        1234567.0,      1234567],
                    ['12.34',           1234.0,         1234],
                    ['12.345',          12345.0,        12345],
                    ['-12.345',         -12345.0,       -12345],
                    ['text',            0.0,            0],
                    [',12',             0.12,           0],
                ],
                'separator' => DecimalSeparator::COMMA,
            ],
        ];
    }

    /**
     * @dataProvider conversionData
     */
    public function testConversion($testCases, $separator)
    {
        foreach ($testCases as $testCase) {
            [$input, $expectedFloat, $expectedInt] = $testCase;
            $this->assertSame($expectedFloat, Num::float($input, $separator));
            $this->assertSame($expectedInt, Num::int($input, $separator));
        }
    }
}
