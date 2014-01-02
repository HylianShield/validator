<?php
/**
 * Validate positive floats.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\Float;

/**
 * Positive.
 */
class Positive extends \HylianShield\Validator\Float
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'float_positive';

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
