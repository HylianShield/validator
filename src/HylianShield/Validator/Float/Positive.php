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
    protected $type = 'positive_float';

    /**
     * Create a validator for a positive float.
     */
    public function __construct()
    {
        // PHP normally uses a precision of the IEEE 754 double precision format.
        // @see http://php.net/manual/en/language.types.float.php
        parent::__construct(1e-16);
    }
}
