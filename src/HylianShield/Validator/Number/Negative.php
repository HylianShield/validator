<?php
/**
 * Validate negative numbers.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\Number;

/**
 * Negative.
 */
class Negative extends \HylianShield\Validator\Range\Immutable
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'number_negative';

    /**
     * The maximum length of the value.
     *
     * PHP normally uses a precision of the IEEE 754 double precision format.
     * @see http://php.net/manual/en/language.types.float.php
     *
     * @var float $maxLength
     */
    protected $maxLength = -1e-16;

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
