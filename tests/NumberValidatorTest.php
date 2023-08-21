<?php

namespace Num\Tests;

use Num\NumberValidator;
use PHPUnit\Framework\TestCase;

class NumberValidatorTest extends TestCase
{
    /**
     * @dataProvider validIntegerNumbersProvider
     */
    public function testValidIntegerNumbers($input)
    {
        $this->assertTrue(NumberValidator::canBeInteger($input));
    }

    /**
     * @dataProvider invalidIntegerNumbersProvider
     */
    public function testInvalidIntegerNumbers($input)
    {
        $this->assertFalse(NumberValidator::canBeInteger($input));
    }

    public static function validIntegerNumbersProvider()
    {
        return [
            ['123'],
            ['1,234'],
            ['1.234'],
            ['1,234,567'],
        ];
    }

    public static function invalidIntegerNumbersProvider()
    {
        return [
            ['1,23'],
            ['1423,233'],
            ['1.2'],
            ['1.2345'],
            ['000.123'],
            ['0.123'],
            ['0.12'],
        ];
    }
}
