<?php
/**
 * Explicitly invalidate a value by inversing the result.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator;

use \InvalidArgumentException;
use \LogicException;

/**
 * LogicalNot.
 */
class LogicalNot extends \HylianShield\Validator
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'not';

    /**
     * The identifier of the validator passed to LogicalNot.
     *
     * @var callable $validatorIdentifier
     */
    private $gateType;

    /**
     * Initialize the validator.
     *
     * @param \HylianShield\Validator $validator
     */
    final public function __construct(\HylianShield\Validator $validator)
    {
        $type =& $this->type;
        $this->gateType = function () use ($validator, $type) {
            return "{$type}({$validator})";
        };

        // Create a custom validator that returns the inverse value of the
        // supplied validator.
        $this->validator = function ($value) use ($validator) {
            return !$validator($value);
        };
    }

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
