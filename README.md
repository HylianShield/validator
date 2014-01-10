# ![Hylian Shield](http://goo.gl/N6ugyU) Hylian Shield

[![Build Status](https://travis-ci.org/johmanx10/hylianshield.png?branch=master)](https://travis-ci.org/johmanx10/hylianshield)
[![Latest Stable Version](https://poser.pugx.org/hylianshield/hylianshield/v/stable.png)](https://packagist.org/packages/hylianshield/hylianshield)
[![Latest Unstable Version](https://poser.pugx.org/hylianshield/hylianshield/v/unstable.png)](https://packagist.org/packages/hylianshield/hylianshield)
[![Dependency Status](https://www.versioneye.com/user/projects/52c7eaadec137524070000b5/badge.png)](https://www.versioneye.com/user/projects/52c7eaadec137524070000b5)
[![Coverage Status](https://coveralls.io/repos/johmanx10/hylianshield/badge.png)](https://coveralls.io/r/johmanx10/hylianshield)
[![Total Downloads](https://poser.pugx.org/hylianshield/hylianshield/downloads.png)](https://packagist.org/packages/hylianshield/hylianshield)

Everything between your input and app.

## Support

By a fault, we support PHP 5.3, 5.4 and 5.5, which are all unit tested using Travis CI.

## What is HylianShield?
The origins of the Hylian Shield can be found in the lore of Zelda games. However, we use both meanings of adventure and shielding to describe our HylianShield.

HylianShield will barricade nasty data from your application. It tries to solve this by supplying powerful validators and sanitizers. Version 0.1 only holds validators, so we will focus on that for now.

### Validators

Data validation is not just about keeping your application secure. Although it should help you determine if data was malformed, it will also help you write stricter and less buggy code.

We recognize that PHP has no proper type hinting for scalar data types. This is a huge pain to deal with, since arguments that should accept scalar values, actually will support the `mixed` data type, meaning any and all data you find laying around in your application can be sent through there. Ouch.

Imagine the following:

```php
<?php
use \InvalidArgumentException;

public function addPerson ($name, $age, $money) {
	// Check the name argument.
	if (!is_string($name) || strlen($name) < 1 || strlen($name) > 255) {
		throw new InvalidArgumentException(
			'Invalid $name supplied. Expected a string between 1 and 255 in length: ('
			. gettype($name) . ') ' . var_export($name, true)
		);
	}

	if (!is_int($age) || $age < 18) {
		throw new InvalidArgumentException(
			'Invalid $age supplied. Expected an integer >= 18: ('
			. gettype($age) . ') ' . var_export($age, true)
		);
	}

	if (!(is_int($money) || is_float($money)) || $money <= 0) {
		throw new InvalidArgumentException(
			'Invalid $money supplied. Expected an integer or float > 0: ('
			. gettype($money) . ') ' . var_export($money, true)
		);
	}
}

```

As you can see, that is a lot of typing, you can easily get this stuff wrong, especially when it gets more complex than this.

What if the wonderful world could allow you to do this?

```php
<?php
use \InvalidArgumentException;
use \HylianShield\Validator;

public function addPerson ($name, $age, $money, $website, $endOfLease) {
	$validName = new Validator\String(1, 255);
	$validAge = new Validator\Integer(18);
	$validMoney = new Validator\Number\Positive;
	$validWebsite = new Validator\Url\Webpage;
	$validLease = new Validator\Date\Mysql;

	if (!$validName($name)) {
		throw new InvalidArgumentException($validName->getMessage());
		// Invalid value supplied: (array) array(12); Expected: string:1,255
	}

	if (!$validAge->validate($age)) {
		throw new InvalidArgumentException($validAge->getMessage());
		// Invalid value supplied: (string) "19"; Expected: integer:18,0
	}

	if (!$validMoney($money)) {
		throw new InvalidArgumentException(
			$validMoney->type() . '. ' . $validMoney->getMessage()
		);
		// number_positive. Invalid value supplied: (string) "19"; Expected: number_positive
	}

	if (!$validWebsite($website)) {
		throw new InvalidArgumentException($validWebsite->getMessage());
		// Invalid value supplied: (string) "abracadabra"; Expected: url_website
	}

	if (!$validLease($endOfLease)) {
		throw new InvalidArgumentException("Expected: {$validLease}");
		// Expected: date_mysql:/^\d{4}\-\d{2}\-\d{2}&/
	}
}
```

With HylianShield, you can. Validators can be used as often as you like as well.

Want to filter out all negative numbers from a range? No biggy:

```php
<?php
$positiveNumbers = array_filter(
	range(-100, 100),
	new \HylianShield\Validator\Integer\Positive
);
// $positiveNumbers will now hold a range of 1..100.
```

For more examples and documentation about specific validators, have a look at [the wiki](https://github.com/johmanx10/hylianshield/wiki). There is some sweet awesome and exotic stuff in there, like the Logical Gates, which enable you to combine validators.

Want to filter out all teenagers from a range? Let's shoot 'm down:

```php
<?php
use \HylianShield\Validator;
use Validator\Integer;
use Validator\LogicalNot;
use Validator\LogicalAnd;

$noTeensAllowed = array_filter(
	range(-100, 100),
	new LogicalAnd(
		new Integer(1, 100),
		new LogicalNot(new Integer(10, 18))
	)
);
// $noTeensAllowed will now hold a range of 1..100, excluding 10..18.
```

## Installation

### As a composer package

Simply add `"hylianshield/hylianshield": ">=0.1.0"` to your `composer.json` and run `php composer.phar install`.
Thanks to free packaging over at [packagist.org](https://packagist.org/packages/hylianshield/hylianshield)

### As a submodule on git

```
$ git submodule add git@github.com:johmanx10/hylianshield.git /path/to/vendor/HylianShield
$ git submodule update --init --recursive /path/to/vendor/hylianshield
$ git commit -am 'Added HylianShield to our submodules'
```

### For developers

First you fork this repo on github or wherever. Then you clone and install:

```
$ git clone git@github.com:yourawesomeusername/hylianshield.git
$ cd hylianshield
$ make
$ make install
```

If you want to use your own version of composer, please install by the following steps:

```
$ git clone git@github.com:yourawesomeusername/hylianshield.git
$ cd hylianshield
$ make precommit
$ php /path/to/composer.phar install --dev
$ make test
```

This will skip downloading and installing composer
