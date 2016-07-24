<?php
namespace HylianShield\Validator;

final class NotValidator implements ValidatorInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * NotValidator constructor.
     *
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Get the identifier for the validator.
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return sprintf('not(<%s>)', $this->validator->getIdentifier());
    }

    /**
     * Validate the given subject.
     *
     * @param mixed $subject
     * @return bool
     */
    public function validate($subject): bool
    {
        return !$this->validator->validate($subject);
    }
}
