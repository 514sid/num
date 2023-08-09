# Num

[![Latest Stable Version](http://poser.pugx.org/514sid/num/v)](https://packagist.org/packages/514sid/num)
[![Total Downloads](http://poser.pugx.org/514sid/num/downloads)](https://packagist.org/packages/514sid/num)
[![License](http://poser.pugx.org/514sid/num/license)](https://packagist.org/packages/514sid/num)


An accurate PHP helper for parsing numbers from strings with support for various thousands and decimal separators.

## Requirements

[![PHP Version Require](http://poser.pugx.org/514sid/num/require/php)](https://packagist.org/packages/514sid/num)

## Installation

```
$ composer require 514sid/num
```

## What It Does

The built-in PHP functions `intval()` and `floatval()`, along with typecasting, may not always correctly handle varying numeric value formats based on regional standards.

```php
floatval("1 234 567.89") // float(1)
intval("1,234.56") // int(1)
```

With the `Num` helper, you can achieve the desired functionality.

You have the option to provide the decimal separator to the `int()` or `float()` methods.

Alternatively, you can allow the `Num` helper to make an educated guess if you're unsure about the exact separator used in a specific string representing a numeric value.
```php
use Num\Num;

Num::float('1,234,567.89', Num::POINT) // float(1234567.89)
Num::float('1.234.567,89', Num::COMMA) // float(1234567.89)
// or
Num::float('1,234,567.89') // float(1234567.89)
Num::float('1.234.567,89') // float(1234567.89)

Num::int('1,234,567.89') // int(1234567)
Num::int('1.234.567,89') // int(1234567)

Num::float('text') // float(0.0)
Num::int('text') // int(0)
```

## How It Works

When you pass a decimal separator as the second argument to the `int()` or `float()` static methods, they remove everything from the string except digits and the decimal separator, and then perform typecasting using PHP's built-in functionality.

If you do not specify a decimal separator, the `Num` helper tries to guess it using the `guessDecimalSeparator()` method, which relies on formatting conventions from the Wikipedia article: https://en.wikipedia.org/wiki/Decimal_separator.

I am still working on improving `guessDecimalSeparator()`, so it might not be 100% accurate.

In most locales, for numbers smaller than 100000, a thousand separator is used based on powers of 1000.

This means that if a string is provided with only one dot or comma and there are 3 digits following it, the guesser will treat this number as a whole number; otherwise it will treat it as a float.
```php
use Num\Num;

Num::float('12.34567') // float(12.34567)
Num::float('12.34') // float(12.34)
Num::float('12.345') // float(12345.0)
```

## License

[MIT](LICENSE)
