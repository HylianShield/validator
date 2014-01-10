<?php
/**
 * Validate a conditional list in a logical gate.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator;

use \InvalidArgumentException;
use \LogicException;

/**
 * LogicalGate.
 */
abstract class LogicalGate extends \HylianShield\Validator
{
    /**
     * A callable to return the combined type of the collection of internal validators.
     *
     * @var callable $gateType
     */
    private $gateType;

    /**
     * Initialize the validator.
     *
     * @param \HylianShield\Validator $1
     * @param \HylianShield\Validator $2 optional
     * @throws \InvalidArgumentException if one of the validators is not an instance
     *   of \HylianShield\Validator
     * @throws \LogicException if less than 2 validators appear to be present
     */
    final public function __construct()
    {
        // Gather all validators and check if they are valid validators.
        $validators = array_filter(
            func_get_args(),
            // Now test them all against being an instance of our validator abstract.
            function ($instance) {
                if (!($instance instanceof \HylianShield\Validator)) {
                    throw new InvalidArgumentException(
                        'Supplied argument is not a valid instance: ('
                        . gettype($instance) . ') ' . var_export($instance, true)
                    );
                }

                return true;
            }
        );

        // Create a function that can tell us the type of all validators.
        // This is useful when debugging a nested validation.
        $type =& $this->type;
        $this->gateType = function () use ($validators, $type) {
            return "{$type}(" . implode('; ', array_map('strval', $validators)) . ')';
        };

        // At least 2 validators should be present.
        if (count($validators) < 2) {
            throw new LogicException(
                'Cannot perform a logical gate with less than two validators.'
            );
        }

        // Create a validator.
        $this->createValidator($validators);

        // Check if the implemtation kept its promise.
        if (!is_callable($this->validator)) {
            // @codeCoverageIgnoreStart
            throw new LogicException(
                'Invalid implementation of createValidator by ' . get_class($this)
                . '. It should set a callable to property validator.'
            );
            // @codeCoverageIgnoreEnd
        }
    }

    /**
     * Create a validator based on a set of validators.
     *
     * @param array $validators
     * @return void
     */
    abstract protected function createValidator(array $validators = array());

    /**
     * Return an identifier.
     *
     * @return string
     */
    final public function __tostring()
    {
        return call_user_func_array($this->gateType, array());
    }
}
