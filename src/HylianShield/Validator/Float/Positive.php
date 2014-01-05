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
     * The boundary for a positive float.
     * PHP normally uses a precision of the IEEE 754 double precision format.
     *
     * @see http://php.net/manual/en/language.types.float.php
     * @var float BOUNDARY
     */
    const BOUNDARY = 1.11e-16;

    /**
     * Create a validator for a positive float.
     */
    public function __construct()
    {
        $this->validator = new Float($this::BOUNDARY);
    }
}
