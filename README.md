# Validator

[![Build Status](https://travis-ci.org/HylianShield/validator.png?branch=master)](https://travis-ci.org/HylianShield/validator)
[![Latest Stable Version](https://poser.pugx.org/hylianshield/validator/v/stable.png)](https://packagist.org/packages/hylianshield/validator)
[![Latest Unstable Version](https://poser.pugx.org/hylianshield/validator/v/unstable.png)](https://packagist.org/packages/hylianshield/validator)

Everything between your input and app.

## Support

To a fault, we support PHP 5.3, 5.4 and 5.5, which are all unit tested using Travis CI.

## What is the HylianShield validator?

HylianShield will barricade nasty data from your application. It tries to solve this by supplying powerful validators.

Data validation is not just about keeping your application secure. Although it should help you determine if data was malformed, it will also help you write stricter and less buggy code.

We recognize that PHP has no proper type hinting for scalar data types. This is a huge pain to deal with, since arguments that should accept scalar values, actually will support the `mixed` data type, meaning any and all data you find laying around in your application can be sent through there.

## Use case

We are an online shop. Our customer base is between 6 and 65 year olds.
However, we do not want any of those teenagers lurking around our store. We are cranky like that.

So now we want to ensure that all our customers adhere to those limits. Let's install a portal that scans their social security cards and reads out their date of birth.

```php
<?php
use \HylianShield\Validator;

// We allow customers between 6 and 65.
$minimumAge = 6;
$maximumAge = 65;

// But we don't like teenagers in our store.
$disallowedAgeStart = 12;
$disallowedAgeEnd = 18;

// So our valid ages are between 6 and 65, excluding 12 through 18.
$validAge = new Validator\LogicalAnd(
    // We allow customers between the minimum and maximum age ...
    new Validator\Integer($minimumAge, $maximumAge),
    // ... so long as they are not ...
    new Validator\LogicalNot(
        // ... between the disallowed ages.
        new Validator\Integer($disallowedAgeStart, $disallowedAgeEnd)
    )
);

// We see customers between the age of 1 through 120.
$suppliedAges = range(1, 120);

// Of those, we allow the following.
// This works because $validAge->__invoke($argument) maps to $validAge->validate($argument).
$validAges = array_filter($suppliedAges, $validAges);

// Owh and here is Jim.
$jim = new Customer();
// He was born in 2007 on May 22th.
$jim->setDateOfBirth(new DateTime('2007-03-22'));

// Today it is June 12th 2014.
$today = new DateTime('2014-06-12');
$jimsAge = $jim->getAge($today); // 7.

if ($validAge->validate($jimsAge)) {
    // Jim is 7 years old, so he can pass!
}

// And here is Jane. She is 14 years old.
// Just the teenager we did not want.
$jane = new Customer();
$jane->setDateOfBirth(new DateTime('2000-02-11'));
$janesAge = $jane->getAge($today);

if (!$validAge->validate($janesdAge)) {
    // YOU SHALL NOT PASS!
    throw new \Vendor\Project\InvalidAgeException(
        $validAge->getMessage();
        // The message will be the following:
        // Invalid value supplied: (integer) 14; Expected: and(integer:6,65; not(integer:12,18))
    );
}

// And if you ever want to know what validator you are dealing with, simply cast it to a string:
echo $validAge; // and(integer:6,65; not(integer:12,18))
```

## List of validators

### Core
- `Boolean`
- `CoreArray([integer $minCount][, integer $maxCount])`
- `CoreFunction`
- `Object`
- `Regexp(string $pattern)`
- `String([integer $minLength][, integer $maxLength])`

### Date
- `Date\Mysql`

### Class
- `CoreClass\Exists([boolean $useAutoloader = true])`
- `CoreClass\Instance(string $class)`
- `CoreClass\Method(string $class)`

### Number
- `Float([integer $minLength][, integer $maxLength])`
- `Float\Negative`
- `Float\Positive`
- `Integer([integer $minLength][, integer $maxLength])`
- `Integer\Negative`
- `Integer\Positive`
- `Number([integer $minLength][, integer $maxLength])`
- `Number\Negative`
- `Number\Positive`

### String
- `String\Utf8([integer $minLength][, integer $maxLength])`
- `String\Utf8\Mes1([integer $minLength][, integer $maxLength])`
- `String\Utf8\Mes2([integer $minLength][, integer $maxLength])`
- `String\Utf8\Mes3A([integer $minLength][, integer $maxLength])`
- `String\Utf8\WordCharacter([integer $minLength][, integer $maxLength])`

### Url
- `Url\Network`
- `Url\Network\Http`
- `Url\Network\Https`
- `Url\Network\Webpage`

### LogicalGate

- `LogicalAnd(\HylianShield\ValidatorAbstract $a, \HylianShield\ValidatorAbstract $b, [, ...])`
- `LogicalOr(\HylianShield\ValidatorAbstract $a, \HylianShield\ValidatorAbstract $b, [, ...])`
- `LogicalXor(\HylianShield\ValidatorAbstract $a, \HylianShield\ValidatorAbstract $b)`
- `LogicalNot(\HylianShield\ValidatorAbstract $validator)`

### Financial

Documentation is coming soon!
