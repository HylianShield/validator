<?php
/**
 * Create an abstract for validators.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield;

use \InvalidArgumentException;
use \LogicException;

/**
 * ValidatorAbstract.
 */
class ValidatorAbstract
{
    /**
     * The minimum length of the value.
     *
     * @var integer $minLength
     */
    protected $minLength = 0;

    /**
     * The maximum length of the value.
     *
     * @var integer $maxLength
     */
    protected $maxLength = 0;

    /**
     * The function to use when checking the length. It has to return a numeric value.
     *
     * @var callable $lengthCheck
     */
    protected $lengthCheck = 'strlen';

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
     * Check the properties of the validator to ensure a perfect implementation.
     *
     * @param integer $minLength the minimum length of the value
     * @param integer $maxLength the maximum length of the value
     * @throws \InvalidArgumentException when either minLength of maxLength is not an integer
     */
    public function __construct($minLength = 0, $maxLength = 0)
    {
        if (!is_int($minLength) || !is_int($maxLength)) {
            throw new InvalidArgumentException(
                'Min and max length should be of type integer.'
            );
        }

        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
    }

    /**
     * Validate the supplied value against the current validator.
     *
     * @param mixed $value
     * @return boolean
     * @throws \LogicException when $this->validator or $this->lengthCheck is not callable
     * @throws \LogicException when either minLength of maxLength is not an integer
     */
    final public function validate($value)
    {
        if (!is_callable($this->validator)) {
            throw new LogicException('Validator should be callable!');
        }

        if (!is_callable($this->lengthCheck)) {
            throw new LogicException('Length checker should be callable!');
        }

        $minLength = $this->minLength;
        $maxLength = $this->maxLength;

        if (!is_int($minLength) || !is_int($maxLength)) {
            throw new LogicException(
                'Min and max length should be of type integer.'
            );
        }

        $valid = true;

        // Check if the validator validates.
        $valid = $valid && call_user_func_array($this->validator, array($value));

        // Check if the minimum length validates.
        $valid = $valid && (
            $minLength === 0
            || call_user_func_array($this->lengthCheck, array($value)) >= $minLength
        );

        // Check if the maximum length validates.
        $valid = $valid && (
            $maxLength === 0
            || call_user_func_array($this->lengthCheck, array($value)) <= $maxLength
        );

        return $valid;
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
        return "{$this->type}:{$this->minLength},{$this->maxLength}";
    }
}
