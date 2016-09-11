<?php
use HylianShield\Validator\ValidatorInterface;

require_once __DIR__ . '/../vendor/autoload.php';

$context = new SplDoublyLinkedList();

$validator = new class implements ValidatorInterface
{
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

$mediator = new class($validator, $context) implements ValidatorInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var SplDoublyLinkedList
     */
    private $context;

    /**
     * Mediator  constructor.
     *
     * @param ValidatorInterface  $validator
     * @param SplDoublyLinkedList $context
     */
    public function __construct(
        ValidatorInterface $validator,
        SplDoublyLinkedList $context
    ) {
        $this->validator = $validator;
        $this->context   = $context;
    }

    /**
     * Get the identifier for the validator.
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->validator->getIdentifier();
    }

    /**
     * Validate the given subject.
     *
     * @param mixed $subject
     * @return bool
     */
    public function validate($subject): bool
    {
        $isValid = $this->validator->validate($subject);

        $this
            ->context
            ->push([
                'identifier' => $this->getIdentifier(),
                'subject' => $subject,
                'isValid' => $isValid
            ]);

        return $isValid;
    }
};

/** @var ValidatorInterface $mediator */
$mediator->validate('foo');
$mediator->validate('Foo');

foreach ($context as $validation) {
    echo json_encode($validation, JSON_PRETTY_PRINT) . PHP_EOL;
}
