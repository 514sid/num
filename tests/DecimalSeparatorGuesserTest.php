<?php

namespace Num\Tests;

use PHPUnit\Framework\TestCase;
use Num\DecimalSeparatorGuesser;

class DecimalSeparatorGuesserTest extends TestCase
{
    public static function decimalSeparatorProvider()
    {
        return [
            ['1,234,567.89',     '.'],
            ['1,234,567',        '.'],
            ['1 234 567.89',     '.'],
            ['123,4567.89',      '.'],
            ['1\'234\'567.89',   '.'],
            ['123',              '.'],
            ['text',             '.'],
            ['12.34567',         '.'],
            ['12,345',           '.'],
            ['.12',              '.'],
            ['12,3456',          ','],
            ['1.234.567,89',     ','],
            ['1 234 567,89',     ','],
            ['1\'234\'567,89',   ','],
            ['12,34567',         ','],
            [',12',              ','],
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
