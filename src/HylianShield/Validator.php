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
     * Temporary storage of the value to be validated.
     *
     * @var string $lastValue
     */
    private $lastValue;

    /**
     * Temporary storage of the validation result.
     *
     * @var string $lastResult
     */
    protected $lastResult;

    /**
     * Set a message to be retrieved if a value doesn't pass the validator.
     *
     * @var string $lastMessage
     */
    private $lastMessage = null;

    /**
     * Validate the supplied value against the current validator.
     *
     * @param mixed $value
     * @return boolean
     * @throws \LogicException when $this->validator is not callable
     */
    public function validate($value)
    {
        $this->lastValue = $value;
        $this->lastMessage = null;

        if (!is_callable($this->validator)) {
            // @codeCoverageIgnoreStart
            throw new LogicException('Validator should be callable!');
            // @codeCoverageIgnoreEnd
        }

        // Check if the validator validates.
        $this->lastResult = (bool) call_user_func_array($this->validator, array($this->lastValue));

        return $this->lastResult;
    }

    /**
     * Get the message explaining the fail.
     *
     * @todo Add message for objects and arrays
     * @return string
     */
    final public function getMessage() {
        // Create a message.
        if ($this->lastResult === false && !isset($this->lastMessage)) {
            if (is_scalar($this->lastValue)) {
                $this->lastMessage = 'Invalid value supplied: (' . gettype($this->lastValue) . ') '
                    . var_export($this->lastValue, true) . "; Expected: {$this}";
            } else {
                $this->lastMessage = "Invalid value supplied; Expected: {$this}";
            }
        }

        return $this->lastMessage;
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
            // @codeCoverageIgnoreStart
            throw new LogicException(
                'Property type should be of data type string!'
            );
            // @codeCoverageIgnoreEnd
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
