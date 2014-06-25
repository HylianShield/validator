# Quick reference

All the validators below live in the `\HylianShield\Validator` namespace.
For a complete documentation, please visit our [API doc](http://hylianshield.github.io/validator/).

## Validator API

For a complete documentation, please visit our [API doc](http://hylianshield.github.io/validator/).
The common interface of validators is:

```php
<?php
// Your validator.
class Validator extends \HylianShield\Validator;

$validator = new Validator;

// The value we will validate.
$input = 'some value';

// Validate.
$isValid = $validator->validate($input);

// Or validate through invoke.
$isValid = $validator($input);

// Get an exception message if the validation failed.
if (!$isValid) {
    throw new Exception($validator->getMessage());
}

// Or throw a custom message:
if (!$isValid) {
    throw new Exception(
        "Input validation failed constraint: {$validator}"
    );
}

// We should also be able to identify the type of the validator.
$validatorsByType = array(
    $validator->type() => $validator
);

// Or to ensure a more unique identifier.
$uniqueValidators = array(
    "{$validator}" => $validator
);
```

## Core
- `Boolean`
- `CoreArray([integer $minCount][, integer $maxCount])`
- `CoreFunction`
- `Object`
- `Regexp(string $pattern)`
- `String([integer $minLength][, integer $maxLength])`

## Date
- `Date\Mysql`

## Class
- `CoreClass\Exists([boolean $useAutoloader = true])`
- `CoreClass\Instance(string $class)`
- `CoreClass\Method(string $class)`

## Number
- `Float([integer $minLength][, integer $maxLength])`
- `Float\Negative`
- `Float\Positive`
- `Integer([integer $minLength][, integer $maxLength])`
- `Integer\Negative`
- `Integer\Positive`
- `Number([integer $minLength][, integer $maxLength])`
- `Number\Negative`
- `Number\Positive`

## String
- `String\Utf8([integer $minLength][, integer $maxLength])`
- `String\Utf8\Mes1([integer $minLength][, integer $maxLength])`
- `String\Utf8\Mes2([integer $minLength][, integer $maxLength])`
- `String\Utf8\Mes3A([integer $minLength][, integer $maxLength])`
- `String\Utf8\WordCharacter([integer $minLength][, integer $maxLength])`

## Url
- `Url\Network`
- `Url\Network\Http`
- `Url\Network\Https`
- `Url\Network\Webpage`

## Email
- `Email`

## LogicalGate

- `LogicalAnd(\HylianShield\Validator $a, \HylianShield\Validator $b, [, ...])`
- `LogicalOr(\HylianShield\Validator $a, \HylianShield\Validator $b, [, ...])`
- `LogicalXor(\HylianShield\Validator $a, \HylianShield\Validator $b)`
- `LogicalNot(\HylianShield\Validator $validator)`

## Financial

- `Financial\Bic([boolean $allowTestBic = false])`
- `Financial\Iban`
- `Financial\ISO20022\ExtLocalInstrumentCode`
- `Financial\ISO20022\ExtOrganizationIdCode`
- `Financial\ISO20022\ExtPersonIdCode`
- `Financial\SEPA\CreditorIdentifier`

## Encoding

- `Base64([integer $options = Base64::VALIDATE_PADDING])`

## File

- `File\Exists`
- `File\Readable`
- `File\Writable`

## OneOf

- `OneOf(mixed $a[, mixed $b[, ...]])`
- `OneOf\Many(array $arguments)`
