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
class LogicalNot extends \HylianShield\ValidatorAbstract
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'not';

    /**
     * Initialize the validator.
     *
     * @param \HylianShield\ValidatorAbstract $validator
     */
    final public function __construct(\HylianShield\ValidatorAbstract $validator)
    {
        // Create a custom validator that returns the inverse value of the
        // supplied validator.
        $this->validator = function ($value) use ($validator) {
            return !$validator($value);
        };
    }
}
