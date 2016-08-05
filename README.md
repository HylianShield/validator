# HylianShield Validator

The HylianShield validator is a validation package, built to create a
common validator interface.

Its current release is explicitly built with PHP7 in mind.
When compared to its predecessor, the current version of the
HylianShield validator package is stripped down to the bare essential
needs for validation.

## Installation

`composer require hylianshield/validator:^2.1.0`

## Configuration

For this package, there is no configuration to consider.

## Validator

A validator consists of at least the following two methods:

### getIdentifier

```php
public function getIdentifier(): string
```

This method is used to create a unique identifier for the validator.
It is of use when debugging behavior of validators or identifying 
validators that have blocked out certain validation subjects.

### validate

```php
public function validate($subject): bool
```

The validate method accepts a validation subject and returns whether the
subject is or is not valid.

## Validator Collection

Besides an interface for validators to implement, a validator collection
interface is exposed.

This collection itself implements an interface that extends the validator
interface. Therefore, a validator collection itself is a validator.

Besides the shared functionality of a validator, it has a method to add
a validator, as well as a method to remove a validator.

If the `validate` method is called on a collection, it will validate
against the validators inside the collection.

Depending on which of the following collections is used, the validation
result will differ:

| Collection          | Result                                                  |
|---------------------|---------------------------------------------------------|
| MatchAllCollection  | Returns true when all internal validators return true.  |
| MatchNoneCollection | Returns true when all internal validators return false. |
| MatchAnyCollection  | Returns true when any internal validator returns true.  |

Because a collection is a validator itself, it can accept another
collection as a registered validator.

**Note:** To not negatively impact performance, there is no test against
registering collections recursively.
Because of this, when a collection is poorly built, it may render
function nesting overflows.

Additionally, the collections keep nesting the formatting of identifiers.
Given that a `MatchAnyCollection` holds validators with identifiers *Foo*
and *Bar*, respectively, the identifier of the collection will be:

```
any(<Foo>, <Bar>)
```

If one would nest a level deeper, combined with `MatchAllCollection`,
one can get the following:

```
any(<Foo>, all(<Bar>, <Baz>))
```

This particular validator will pass if the *Foo* validator passes, if
both the *Bar* and *Baz* validators pass or if all three validators pass.

## NotValidator

When one wants to invert the validation of any given validator or
collection, one can wrap it around a `NotValidator`.

```php
/** ValidatorInterface $validator */
$notValidator = new NotValidator($validator);

$validator->validate('something'); // true
$notValidator->validate('something'); // false

$validator->validate('somethingElse'); // false
$notValidator->validate('somethingElse'); // true

echo $validator->getIdentifier(); // something
echo $notValidator->getIdentifier(); // not(<something>)
```

## Anonymous validator

As of PHP 7, PHP supports anonymous classes. One can easily create a
custom validator without having to introduce a fully qualified class name
for its validator.

```php
use HylianShield\Validator\ValidatorInterface;
use Acme\User\UserManagerInterface;

$userValidator = new class($userManager) implements ValidatorInterface {
    /**
     * @var UserManagerInterface
     */
    protected $userManager;
    
    /**
     * Initialize a new user validator.
     *
     * @param UserManagerInterface $userManager
     */*
    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }
    
    /**
     * Get the identifier for the validator.
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return 'user';
    }

    /**
     * Validate the given subject.
     *
     * @param mixed $subject
     * @return bool
     */
    public function validate($subject): bool
    {
        return $this->userManager->contains($subject);
    }
};
```

And with this you have created a validator that can assert if a given
user exists.

You could even combine it with existing validators.

```php
use HylianShield\Validator\Collection\MatchAllCollection;
use Acme\User\Role\RoleValidator;
use Acme\User\Role\AdminRole;

$adminValidator = new MatchAllCollection();
$adminValidator->addValidator($userValidator);
$adminValidator->addValidator(
    new RoleValidator(AdminRole::IDENTIFIER)
);

$adminValidator->validate($nonexistentUser); // false
$adminValidator->validate($normalUser);      // false
$adminValidator->validate($adminUser);       // true
echo $adminValidator->getIdentifier();       // all(<user>, <role:admin>)
```

## Invoker

In previous versions of this package, one could pass a validator on to
functions like `array_filter` and `array_map`.

To properly separate concerns in code and to keep the validator interface
clean for implementations, this is now solved by a separate `Invoker` object.

One simply wraps the validator like so:

```php
use HylianShield\Validator\Invoker;

$filtered = array_filter($input, new Invoker($validator));
```

This also works for validator collections.

See invoker code example under `examples/` for an implementation of the
invoker.
