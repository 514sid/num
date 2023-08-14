<?php

namespace Num\Tests;

use Num\Num;
use Num\Enums\DecimalSeparator;
use PHPUnit\Framework\TestCase;

class NumTest extends TestCase
{
    public function testConversionOfNumberWithPointDecimalSeparatorToFloat()
    {
        $this->assertSame(123.0, Num::float('123', DecimalSeparator::POINT));
        $this->assertSame(1234567.89, Num::float('1,234,567.89', DecimalSeparator::POINT));
        $this->assertSame(1234567.0, Num::float('1,234,567', DecimalSeparator::POINT));
        $this->assertSame(1234567.89, Num::float('1 234 567.89', DecimalSeparator::POINT));
        $this->assertSame(1234567.89, Num::float('123,4567.89', DecimalSeparator::POINT));
        $this->assertSame(1234567.89, Num::float('1\'234\'567.89', DecimalSeparator::POINT));
        $this->assertSame(12345.0, Num::float('12,345', DecimalSeparator::POINT));
        $this->assertSame(123456.0, Num::float('12,3456', DecimalSeparator::POINT));
        $this->assertSame(3.14159265359, Num::float('3.14159265359', DecimalSeparator::POINT));
        $this->assertSame(12.30, Num::float('$12.30', DecimalSeparator::POINT));
        $this->assertSame(0.0, Num::float('text', DecimalSeparator::POINT));
        $this->assertSame(0.12, Num::float('.12', DecimalSeparator::POINT));
    }

    public function testConversionOfNumberWithPointDecimalSeparatorToInteger()
    {
        $this->assertSame(123, Num::int('123', DecimalSeparator::POINT));
        $this->assertSame(1234567, Num::int('1,234,567.89', DecimalSeparator::POINT));
        $this->assertSame(1234567, Num::int('1,234,567', DecimalSeparator::POINT));
        $this->assertSame(1234567, Num::int('1 234 567.89', DecimalSeparator::POINT));
        $this->assertSame(1234567, Num::int('123,4567.89', DecimalSeparator::POINT));
        $this->assertSame(1234567, Num::int('1\'234\'567.89', DecimalSeparator::POINT));
        $this->assertSame(12345, Num::int('12,345', DecimalSeparator::POINT));
        $this->assertSame(123456, Num::int('12,3456', DecimalSeparator::POINT));
        $this->assertSame(12, Num::int('12.34567'));
        $this->assertSame(12, Num::int('12,34567'));
        $this->assertSame(12, Num::int('$12.30', DecimalSeparator::POINT));
        $this->assertSame(0, Num::int('text', DecimalSeparator::POINT));
        $this->assertSame(0, Num::int('.12', DecimalSeparator::POINT));
    }

    public function testConversionOfNumberWithCommaDecimalSeparatorToFloat()
    {
        $this->assertSame(123.0, Num::float('123', DecimalSeparator::COMMA));
        $this->assertSame(1234567.89, Num::float('1 234 567,89', DecimalSeparator::COMMA));
        $this->assertSame(1234567.89, Num::float('1.234.567,89', DecimalSeparator::COMMA));
        $this->assertSame(1234567.89, Num::float('1\'234\'567,89', DecimalSeparator::COMMA));
        $this->assertSame(12.345, Num::float('12,345', DecimalSeparator::COMMA));
        $this->assertSame(3.14159265359, Num::float('3,14159265359', DecimalSeparator::COMMA));
        $this->assertSame(12.34567, Num::float('12.34567'));
        $this->assertSame(12.34, Num::float('12.34'));
        $this->assertSame(12345.0, Num::float('12.345'));
        $this->assertSame(0.0, Num::float('text', DecimalSeparator::COMMA));
        $this->assertSame(0.12, Num::float(',12'));
    }

    public function testConversionOfNumberWithCommaDecimalSeparatorToInteger()
    {
        $this->assertSame(123, Num::int('123', DecimalSeparator::COMMA));
        $this->assertSame(1234567, Num::int('1 234 567,89', DecimalSeparator::COMMA));
        $this->assertSame(1234567, Num::int('1.234.567,89', DecimalSeparator::COMMA));
        $this->assertSame(1234567, Num::int('1\'234\'567,89', DecimalSeparator::COMMA));
        $this->assertSame(12, Num::int('12,345', DecimalSeparator::COMMA));
        $this->assertSame(0, Num::int('text', DecimalSeparator::COMMA));
        $this->assertSame(0, Num::int(',12', DecimalSeparator::COMMA));
    }
}