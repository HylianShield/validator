<?php
/**
 * Create an abstract for validators.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield;

use \LogicException;
/**
 * Validator.
 */
abstract class Validator
{
    /**
     * The type of the validator.
     *
     * @var string $type
     */
    protected $type;

    /**
     * A validation function which should always return either true or false and
     * accept a single value to check against.
     *
     * @var callable $validator
     */
    protected $validator;

    /**
     * Validate the supplied value against the current validator.
     *
     * @param mixed $value
     * @return boolean
     * @throws \LogicException when $this->validator is not callable
     */
    public function validate($value)
    {
        if (!is_callable($this->validator)) {
            throw new LogicException('Validator should be callable!');
        }

        // Check if the validator validates.
        return (bool) call_user_func_array($this->validator, array($value));
    }

    /**
     * Called when a class is directly called as if it was a function.
     *
     * @param mixed $value
     * @return boolean
     */
    final public function __invoke($value)
    {
        return $this->validate($value);
    }

    /**
     * Return the type of the current validator.
     *
     * @return string $this->type
     * @throws \LogicException when $this->type is not a string
     */
    final public function type()
    {
        if (!is_string($this->type)) {
            throw new LogicException(
                'Property type should be of data type string!'
            );
        }

        return $this->type;
    }

    /**
     * Return an indentifier.
     *
     * @return string
     */
    public function __tostring()
    {
        return $this->type();
    }
}
