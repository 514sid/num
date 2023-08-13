<?php

namespace Num\Tests;

use Num\NumberValidator;
use PHPUnit\Framework\TestCase;

class NumberValidatorTest extends TestCase
{
    public function testValidIntegerNumbers()
    {
        $this->assertTrue(NumberValidator::canBeInteger('123'));
        $this->assertTrue(NumberValidator::canBeInteger('1,234'));
        $this->assertTrue(NumberValidator::canBeInteger('1.234'));
        $this->assertTrue(NumberValidator::canBeInteger('1,234,567'));
    }

    public function testInvalidIntegerNumbers()
    {
        $this->assertFalse(NumberValidator::canBeInteger('1,23'));
        $this->assertFalse(NumberValidator::canBeInteger('1423,233'));
        $this->assertFalse(NumberValidator::canBeInteger('1.2'));
        $this->assertFalse(NumberValidator::canBeInteger('1.2345'));
    }
}