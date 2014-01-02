<?php
/**
 * Validate positive numbers.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\Number;

/**
 * Positive.
 */
class Positive extends \HylianShield\Validator\Number
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'number_positive';

    /**
     * The minimum length of the value.
     *
     * PHP normally uses a precision of the IEEE 754 double precision format.
     * @see http://php.net/manual/en/language.types.float.php
     *
     * @var integer|float $minLength
     */
    protected $minLength = 1e-16;
}
