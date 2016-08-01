<?php
use HylianShield\Validator\Collection\MatchAllCollection;
use HylianShield\Validator\NotValidator;
use HylianShield\Validator\ValidatorInterface;

require_once __DIR__ . '/../vendor/autoload.php';

$foo = new class implements ValidatorInterface {
    /**
     * Get the identifier for the validator.
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return 'Foo';
    }

    /**
     * Validate the given subject.
     *
     * @param mixed $subject
     * @return bool
     */
    public function validate($subject): bool
    {
        return $subject === $this->getIdentifier();
    }
};

$bar = new class implements ValidatorInterface {
    /**
     * Get the identifier for the validator.
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return 'Bar';
    }

    /**
     * Validate the given subject.
     *
     * @param mixed $subject
     * @return bool
     */
    public function validate($subject): bool
    {
        return true;
    }
};

$collection = new MatchAllCollection();
$collection->addValidator($foo);
$collection->addValidator($bar);

var_dump(
    $collection->validate('Foo'), // true
    $collection->validate('Bar'), // false
    $collection->getIdentifier()  // "all(<Foo>, <Bar>)"
);

$collection->removeValidator($foo);
$collection->addValidator(new NotValidator($foo));

var_dump(
    $collection->validate('Foo'), // false
    $collection->validate('Bar'), // true
    $collection->getIdentifier()  // "all(<Bar>, <not(<Foo>)>)"
);
