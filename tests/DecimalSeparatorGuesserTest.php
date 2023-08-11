<?php

namespace Num\Tests;

use PHPUnit\Framework\TestCase;
use Num\DecimalSeparatorGuesser;

class DecimalSeparatorGuesserTest extends TestCase
{
    public function testGuessingDecimalSeparatorFromNumberString()
    {
        $this->assertSame(DecimalSeparatorGuesser::POINT, DecimalSeparatorGuesser::guess('1,234,567.89'));
        $this->assertSame(DecimalSeparatorGuesser::POINT, DecimalSeparatorGuesser::guess('1,234,567'));
        $this->assertSame(DecimalSeparatorGuesser::POINT, DecimalSeparatorGuesser::guess('1 234 567.89'));
        $this->assertSame(DecimalSeparatorGuesser::POINT, DecimalSeparatorGuesser::guess('123,4567.89'));
        $this->assertSame(DecimalSeparatorGuesser::POINT, DecimalSeparatorGuesser::guess('1\'234\'567.89'));
        $this->assertSame(DecimalSeparatorGuesser::POINT, DecimalSeparatorGuesser::guess('123'));
        $this->assertSame(DecimalSeparatorGuesser::POINT, DecimalSeparatorGuesser::guess('text'));
        $this->assertSame(DecimalSeparatorGuesser::POINT, DecimalSeparatorGuesser::guess('12.34567'));
        $this->assertSame(DecimalSeparatorGuesser::POINT, DecimalSeparatorGuesser::guess('12,345'));
        $this->assertSame(DecimalSeparatorGuesser::COMMA, DecimalSeparatorGuesser::guess('12,3456'));
        $this->assertSame(DecimalSeparatorGuesser::COMMA, DecimalSeparatorGuesser::guess('1.234.567,89'));
        $this->assertSame(DecimalSeparatorGuesser::COMMA, DecimalSeparatorGuesser::guess('1 234 567,89'));
        $this->assertSame(DecimalSeparatorGuesser::COMMA, DecimalSeparatorGuesser::guess('1\'234\'567,89'));
        $this->assertSame(DecimalSeparatorGuesser::COMMA, DecimalSeparatorGuesser::guess('12,34567'));
    }
}
