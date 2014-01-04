<?php
/**
 * Validate positive floats.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\Float;

use \HylianShield\Validator\Float;

/**
 * Positive.
 */
class Positive extends \HylianShield\Validator
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'float_positive';

    /**
     * Create a validator for positive integers.
     */
    public function __construct()
    {
        // PHP normally uses a precision of the IEEE 754 double precision format.
        // @see http://php.net/manual/en/language.types.float.php
        $this->validator = new Float(1e-16);
    }
}
