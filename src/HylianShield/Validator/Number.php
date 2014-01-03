<?php
/**
 * Validate numbers.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator;

use \InvalidArgumentException;

/**
 * Number.
 */
class Number extends \HylianShield\Validator\Range\Mutable
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'number';

    /**
     * The callable to return the length of the value.
     *
     * @var callable $lengthCheck
     */
    protected $lengthCheck = 'floatval';

    /**
     * Create the validator
     *
     * @return callable
     */
    protected function createValidator()
    {
        // Set a custom validator.
        return function ($value) {
            return is_int($value) || is_float($value);
        };
    }
}
