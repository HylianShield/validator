<?php
/**
 * An interface for HylianShield validators and validators based on HylianShield..
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield;

use \HylianShield\Validator\Context\ContextInterface;

/**
 * ValidatorInterface.
 */
interface ValidatorInterface
{
    /**
     * Validate the supplied value against the current validator.
     *
     * @param mixed $value
     * @param ContextInterface $context
     * @return boolean
     */
    public function validate($value, ContextInterface $context = null);

    /**
     * Called when a class is directly called as if it was a function.
     * This should directly forward the call to validate and return its rerults.
     *
     * @param mixed $value
     * @return boolean
     */
    public function __invoke($value);

    /**
     * Get the message explaining the fail.
     *
     * @return string|null
     */
    public function getMessage();

    /**
     * Return the type of the current validator.
     *
     * @return string
     */
    public function getType();

    /**
     * Return an indentifier.
     * This may be more verbose than the return value of getType.
     *
     * @return string
     */
    public function __toString();
}
