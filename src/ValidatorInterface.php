<?php
namespace HylianShield\Validator;

interface ValidatorInterface
{
    /**
     * Get the identifier for the validator.
     *
     * @return string
     */
    public function getIdentifier(): string;

    /**
     * Validate the given subject.
     *
     * @param mixed $subject
     * @return bool
     */
    public function validate($subject): bool;
}
